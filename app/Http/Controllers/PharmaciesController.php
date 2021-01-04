<?php

namespace App\Http\Controllers;

use App\Enums\Pagination;
use App\Forms\PharmacyForm;
use App\Http\Requests\PharmacyRequest;
use App\Http\Resources\PharmacyResource;
use App\Queries\PharmacyQueryInterface;
use App\Repositories\PharmacyRepository;
use Illuminate\Http\Request;

class PharmaciesController extends Controller
{
    /**
     * @var PharmacyRepository
     */
    private $pharmacyRepository;

    public function __construct(PharmacyRepository $pharmacyRepository)
    {
        $this->pharmacyRepository = $pharmacyRepository;
    }

    public function index(Request $request, PharmacyQueryInterface $pharmacyQuery): \Illuminate\Http\Resources\Json\AnonymousResourceCollection
    {
        $perPage = $request->get('perPage', Pagination::DEFAULT_PER_PAGE);
        $page = $request->get('page', Pagination::DEFAULT_PAGE);
        $pharmacies = $pharmacyQuery->execute($perPage,$page);

        return PharmacyResource::collection($pharmacies);
    }

    public function create(PharmacyForm $form)
    {
        return response()->json(['form' => $form->get()]);
    }

    public function store(PharmacyRequest $pharmacyRequest)
    {
        $this->pharmacyRepository->create($pharmacyRequest->validated());

        return response()->json(['message' => __('crud.pharmacy_created')], 201);
    }

    public function show($id)
    {
        return new PharmacyResource($this->pharmacyRepository->findById($id));
    }

    public function edit(PharmacyForm $form, int $id)
    {
        $attr = $this->pharmacyRepository->findById($id);

        return response()->json(['form' => $form->fill($attr)->getSchema()]);
    }

    public function update(PharmacyRequest $pharmacyRequest, $id)
    {
        $this->pharmacyRepository->update($id, $pharmacyRequest->validated());

        return response()->json(['message' => __('crud.pharmacy_updated')]);
    }

    public function destroy($id)
    {
        $this->pharmacyRepository->delete($id);

        return response()->json(['message' => __('crud.pharmacy_deleted')], 200);
    }
}
