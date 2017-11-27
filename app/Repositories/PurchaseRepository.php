<?php
namespace App\Repositories; use App\Models\Purchase; use Yajra\DataTables\Facades\DataTables; class PurchaseRepository extends BaseRepository { protected $model; public function __construct() { $this->model = new Purchase(); } protected function saveModel($sp12db67, $sp68be9c) { foreach ($sp68be9c as $sp22c61b => $sp75a6c8) { $sp12db67->{$sp22c61b} = $sp75a6c8; } $sp12db67->save(); return $sp12db67; } public function store($sp68be9c) { $sp12db67 = $this->saveModel(new $this->model(), $sp68be9c); return $sp12db67; } public function update($sp12db67, $sp68be9c) { $sp12db67 = $this->saveModel($sp12db67, $sp68be9c); return $sp12db67; } public function findById($sp2bf607) { return $this->model->where('id', $sp2bf607)->first(); } public function findByInvoice($sp2bf607) { return $this->model->where('invoice_id', $sp2bf607)->first(); } public function findReportSupplier($spe1dc49, $sp32ff68, $spdf551d) { $sp12db67 = $this->model; if (!is_null($spdf551d)) { $sp12db67 = $sp12db67->where('supplier_id', $spdf551d->id); } $sp12db67 = $sp12db67->whereMonth('created_at', $spe1dc49)->whereYear('created_at', $sp32ff68)->get(); return $sp12db67; } public function createInvoiceId() { $spe5b91c = $this->model->orderBy('id', 'desc')->pluck('id')->first(); $spe5b91c += 1; $sp2bf607 = 'INV-' . str_pad($spe5b91c, 8, '0', STR_PAD_LEFT); $sp7ef4b7 = $this->findByInvoice($sp2bf607); while ($sp7ef4b7) { $spe5b91c += 1; $sp2bf607 = 'INV-' . str_pad($spe5b91c, 8, '0', STR_PAD_LEFT); $sp7ef4b7 = $this->findByInvoice($sp2bf607); } return $sp2bf607; } public function getList($spe81ede = '', $sp0757f9 = '') { if ($spe81ede == '' && $sp0757f9 == '') { $spe88479 = $this->model->query(); } else { $spe88479 = $this->model; if ($spe81ede != '') { $spe88479 = $spe88479->whereDate('created_at', '>=', trim($spe81ede)); } if ($sp0757f9 != '') { $spe88479 = $spe88479->whereDate('created_at', '<=', trim($sp0757f9)); } } $sp68be9c = DataTables::eloquent($spe88479)->addColumn('action', function ($sp12db67) { return view('purchase.action')->with('model', $sp12db67); })->editColumn('is_complete', function ($sp12db67) { if ($sp12db67->is_complete) { return '<span class="badge badge-success">SELESAI</span>'; } else { return '<span class="badge badge-danger">BELUM SELESAI</span>'; } })->editColumn('supplier', function ($sp12db67) { if ($spdf551d = $sp12db67->supplier) { return '<a href="' . route('supplier.edit', array('id' => $spdf551d->id)) . '" target="_blank">' . $spdf551d->supplier_name . '</a>'; } else { return '<span class="badge badge-danger">TIDAK ADA SUPPLIER</span>'; } })->editColumn('total_final', function ($sp12db67) { return number_format($sp12db67->total_final, 0); })->rawColumns(array('is_complete', 'action', 'supplier'))->make(true); return $sp68be9c; } }