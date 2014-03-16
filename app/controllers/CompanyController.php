<?php

class CompanyController extends \BaseController {

	/**
	 * Display a listing of the resource.
	 *
	 * @return Response
	 */
	public function index()
	{
		$companies = Company::all();
		return Response::json($companies->toArray());
	}

	/**
	 * voting for the characteristic
	 */
	public function vote() {
		$ccid = (int) $_POST['ccid'];
		if (!Auth::check()) { // TODO: требование авторизации должно быть в роуте
			return Response::json(array('error' => 'auth'));
		}
		$userId = Auth::user()->id;
		$voteCnt = UserVote::where('userId', '=', $userId)->where('companyCharacteristicId', '=', $ccid)
			->get()->count();
		if ($voteCnt > 0) {
			return Response::json(array('error' => 'duplicate', 'count' => $voteCnt));
		}
		UserVote::create(array('userId' => $userId, 'companyCharacteristicId' => $ccid));
		$cc = CompanyCharacteristic::where('id', '=', $ccid)->first();
		$cc->increment('count');
		return Response::json(array('count' => $cc->count+1));
	}

	/**
	*
	*/
	public function addTag() {
		if (!Auth::check()) { // TODO: требование авторизации должно быть в роуте
			return Response::json(array('error' => 'auth'));
		}
		$userId = Auth::user()->id;
		$companyId = Input::get('companyId');
		$tagName = Input::get('name');
		$characteristic = Characteristic::firstOrCreate(array('name' => $tagName));
		$characteristicId = $characteristic->getAttribute('id');
		$characteristicCompany = CompanyCharacteristic::firstOrNew(array(
				'companyId'        => $companyId,
				'characteristicId' => $characteristicId
			));
		if ($characteristicCompany->exists) {
			return Response::json(array(
					'error' => 'duplicate'
				));
		}
		$characteristicCompany->count = 1;
		$characteristicCompany->save();
		UserVote::create(array('userId' => $userId, 'companyCharacteristicId' => $characteristicCompany->id));
		$out = array(
				'characteristicId' => $characteristicId,
				'characteristicCompanyId' => $characteristicCompany->id
			);
		return Response::json($out);
	}

	/**
	 * Show the form for creating a new resource.
	 *
	 * @return Response
	 */
	public function create()
	{
		//
	}

	/**
	 * Store a newly created resource in storage.
	 *
	 * @return Response
	 */
	public function store()
	{
		if (!Auth::check()) return 0; // TODO: требование авторизации должно быть в роуте
		$companyName = Input::get('companyName');
		$company = Company::create(array(
				'name' => $companyName
			));
		if ($company)
			return $company->id;
		else
			return 0;
	}

	/**
	 * Display the specified resource.
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function show($id)
	{
		if (!is_numeric($id)) return 'The company id must be numeric';
		$company = DB::table('Company')->where('id', '=', $id)->select('name')->first();
		$out = (array) $company;
		$characteristics = DB::table('CompanyCharacteristic')
							->leftJoin('Characteristic', 'CompanyCharacteristic.characteristicId', '=', 'Characteristic.id')
							->where('CompanyCharacteristic.companyId', '=', $id)
							->select('Characteristic.name', 'CompanyCharacteristic.count', 'CompanyCharacteristic.id as ccid')
							->orderBy('CompanyCharacteristic.count', 'desc')
							->get();
		$out['characteristics'] = $characteristics;
		$facts = DB::table('CompanyFact')
					->leftJoin('CompanyFactType', 'CompanyFactType.id', '=', 'CompanyFact.companyFactTypeId')
					->where('CompanyFact.companyId', '=', $id)
					->select('CompanyFactType.name', 'CompanyFact.value')
					->orderBy('CompanyFactType.id', 'asc')
					->get();
		$out['facts']     = $facts;
		$out['companyId'] = $id;
		return Response::json($out);
	}

	/**
	 * Show the form for editing the specified resource.
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function edit($id)
	{
		//
	}

	/**
	 * Update the specified resource in storage.
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function update($id)
	{
		//
	}

	/**
	 * Remove the specified resource from storage.
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function destroy($id)
	{
		//
	}

}