<?php

namespace App\Http\Controllers;

use App\Models\Facility;
use App\Models\Material;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\DB;
use Symfony\Component\HttpFoundation\StreamedResponse;

class FacilityController extends Controller
{
    public function index(Request $request)
    {
        $search = $request->string('q')->toString();
        $materialId = $request->integer('material_id');
        $sort = $request->string('sort', 'updated_desc')->toString();

        $query = Facility::query()->with('materials');

        if ($search !== '') {
            $query->where(function ($q) use ($search) {
                $q->where('business_name', 'like', "%{$search}%")
                  ->orWhere('city', 'like', "%{$search}%")
                  ->orWhereHas('materials', function ($mq) use ($search) {
                      $mq->where('name', 'like', "%{$search}%");
                  });
            });
        }

        if ($materialId) {
            $query->whereHas('materials', function ($q) use ($materialId) {
                $q->where('materials.id', $materialId);
            });
        }

        switch ($sort) {
            case 'updated_asc':
                $query->orderBy('last_update_date', 'asc');
                break;
            case 'updated_desc':
            default:
                $query->orderBy('last_update_date', 'desc');
                break;
        }

        $facilities = $query->paginate(10)->withQueryString();
        $materials = Material::orderBy('name')->get();

        return view('facilities.index', compact('facilities', 'materials', 'search', 'materialId', 'sort'));
    }

    public function create()
    {
        $materials = Material::orderBy('name')->get();
        return view('facilities.create', compact('materials'));
    }

    public function store(Request $request): RedirectResponse
    {
        $validated = $request->validate([
            'business_name' => ['required', 'string', 'max:255'],
            'last_update_date' => ['required', 'date'],
            'street_address' => ['required', 'string', 'max:255'],
            'city' => ['required', 'string', 'max:255'],
            'state' => ['required', 'string', 'max:255'],
            'postal_code' => ['required', 'string', 'max:20'],
            'materials' => ['array'],
            'materials.*' => ['exists:materials,id'],
        ]);

        DB::transaction(function () use ($validated) {
            $materials = $validated['materials'] ?? [];
            unset($validated['materials']);
            $facility = Facility::create($validated);
            $facility->materials()->sync($materials);
        });

        return redirect()->route('facilities.index')->with('status', 'Facility created');
    }

    public function show(Facility $facility)
    {
        $facility->load('materials');
        return view('facilities.show', compact('facility'));
    }

    public function edit(Facility $facility)
    {
        $materials = Material::orderBy('name')->get();
        $facility->load('materials');
        return view('facilities.edit', compact('facility', 'materials'));
    }

    public function update(Request $request, Facility $facility): RedirectResponse
    {
        $validated = $request->validate([
            'business_name' => ['required', 'string', 'max:255'],
            'last_update_date' => ['required', 'date'],
            'street_address' => ['required', 'string', 'max:255'],
            'city' => ['required', 'string', 'max:255'],
            'state' => ['required', 'string', 'max:255'],
            'postal_code' => ['required', 'string', 'max:20'],
            'materials' => ['array'],
            'materials.*' => ['exists:materials,id'],
        ]);

        DB::transaction(function () use ($validated, $facility) {
            $materials = $validated['materials'] ?? [];
            unset($validated['materials']);
            $facility->update($validated);
            $facility->materials()->sync($materials);
        });

        return redirect()->route('facilities.index')->with('status', 'Facility updated');
    }

    public function destroy(Facility $facility): RedirectResponse
    {
        $facility->delete();
        return redirect()->route('facilities.index')->with('status', 'Facility deleted');
    }

    public function exportCsv(Request $request): StreamedResponse
    {
        $search = $request->string('q')->toString();
        $materialId = $request->integer('material_id');
        $sort = $request->string('sort', 'updated_desc')->toString();

        $query = Facility::query()->with('materials');

        if ($search !== '') {
            $query->where(function ($q) use ($search) {
                $q->where('business_name', 'like', "%{$search}%")
                  ->orWhere('city', 'like', "%{$search}%")
                  ->orWhereHas('materials', function ($mq) use ($search) {
                      $mq->where('name', 'like', "%{$search}%");
                  });
            });
        }

        if ($materialId) {
            $query->whereHas('materials', function ($q) use ($materialId) {
                $q->where('materials.id', $materialId);
            });
        }

        switch ($sort) {
            case 'updated_asc':
                $query->orderBy('last_update_date', 'asc');
                break;
            case 'updated_desc':
            default:
                $query->orderBy('last_update_date', 'desc');
                break;
        }

        $rows = $query->get();

        $headers = [
            'Content-Type' => 'text/csv',
            'Content-Disposition' => 'attachment; filename="facilities.csv"',
        ];

        $callback = function () use ($rows) {
            $output = fopen('php://output', 'w');
            fputcsv($output, ['Business Name', 'Last Updated', 'Address', 'Materials Accepted']);
            foreach ($rows as $facility) {
                fputcsv($output, [
                    $facility->business_name,
                    $facility->last_update_date,
                    $facility->full_address,
                    $facility->materials->pluck('name')->implode(', '),
                ]);
            }
            fclose($output);
        };

        return response()->stream($callback, 200, $headers);
    }
}

