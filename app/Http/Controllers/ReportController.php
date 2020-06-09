<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Requests;
use Session;
use View;
use Redirect;
use Validator;
use DB;
use Response;
use Excel;

class ReportController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        if( Session::get('fingerprint') == md5($_SERVER['HTTP_USER_AGENT'] . $_SERVER['REMOTE_ADDR']) ){ 
            return view::make('report.report');
        }else{
            return Redirect::to('login');
        }
    }




    /**
    * get report kpi all
    */
    public function kpiall()
    {
        if( Session::get('fingerprint') == md5($_SERVER['HTTP_USER_AGENT'] . $_SERVER['REMOTE_ADDR']) ){ 
            
            $y = DB::table('kpi_result')->select(DB::raw('year(date_save) as yearAll'))->groupby('date_save')->get();
            $y_name=[];
            $last_y='';
            foreach ($y as $key => $value) {                    
                $y_name[$value->yearAll] = $value->yearAll+543;
                $last_y = $value->yearAll;
            } 
            $last_y++;
            $y_name[$last_y] = $last_y+543;  

            return view::make('report.kpiall', array('yearAll' => $y_name));
        }else{
            return Redirect::to('login');
        }
    }





    public function getReportKpiAll(Request $request)
    {
        if( Session::get('fingerprint') == md5($_SERVER['HTTP_USER_AGENT'] . $_SERVER['REMOTE_ADDR']) ){ 
            $data = $request->input(); 
        
            $messages = [
                'yearAllKpi.required'  => '*'
            ];

            $rules = [
                'yearAllKpi' => 'required'
            ];

            $validator = Validator::make($data, $rules, $messages);
            if ($validator->fails()) {               
                return Redirect::to('report/kpiall')->withInput()->withErrors($validator);
            }else{
                $year = $data['yearAllKpi'];

                $y1 = ($year-1).'-10-01';
                $y2 = $year.'-09-30';

                Excel::create('kpiall'.($year+543), function($excel) use($year, $y1, $y2) {

                    // Set the title
                    $excel->setTitle('KPI ALL');
                    
                    $excel->sheet('KPI ALL', function ($sheet) use($year, $y1, $y2) {
                        $sheet->setOrientation('landscape');
                        $sheet->setWidth(array(
                            'A'     =>  7,
                            'B'     =>  90,
                            'C'     =>  20,
                            'D'     =>  10,
                            'E'     =>  10,
                            'F'     =>  10,
                            'G'     =>  10,
                            'H'     =>  60
                        ));
                        $sheet->row(1, array('KPI ประจำปีงบประมาณ '.($year+543)));
                        $sheet->row(2, array(
                            'ลำดับ', 'รายการ', 'รอบ', 'ตัวตั้ง', 'ตัวหาร', 'ตัวคูณ', 'ผลลัพธ์', 'หมายเหตุ'
                        ));

                        $sql = ' select id, dep_name from department';
                        $result = DB::select($sql); 
                        $row = 2;              
                        foreach ($result as $key) 		   {
                            $i=0;    
                            $sheet->row($row+1, array($key->dep_name));

                            $sql2  = ' select k2.kpi_name_th, concat(a.around_name," รอบที่ ",k1.around) as aname';
                            $sql2 .= ' ,k1.fraction,k1.section,k1.multiply,k1.result,k1.comment';
                            $sql2 .= ' from kpi_result k1';
                            $sql2 .= ' left join kpi k2 on k2.id=k1.kpi_id';
                            $sql2 .= ' left join around a on a.id=k1.around_id';
                            $sql2 .= ' where k1.created_at between "'.$y1.'" and "'.$y2.'" ';
                            $sql2 .= ' and dep_id = '.$key->id.' order by k2.kpi_name_th asc, k1.around_id asc, k1.around asc';

                            $result2 = DB::select($sql2); 

                            if(count($result2) == 0){
                                $sheet->row($row+2, array('-'));
                                $row++;	
                            }

                            foreach ($result2 as $key2){ 
                                $i++;
                                $sheet->row($row+2, array(
                                    $i, $key2->kpi_name_th, $key2->aname, $key2->fraction, $key2->section, $key2->multiply, $key2->result, $key2->comment
                                ));
                                $row++;	
                            }

                            $row++;	
                        }//end foreach

                    });

                })->export('xls');

                /*$objPHPExcel = new PHPExcel();
                $objPHPExcel->getDefaultStyle()->getFont()->setName('Arial'); 
                $objPHPExcel->getActiveSheet()->setTitle('KPI ALL');
                $objPHPExcel->setActiveSheetIndex(0);

                $objPHPExcel->getActiveSheet()->setCellValue('A1', 'KPI ประจำปีงบประมาณ '.($year+543));	
                $objPHPExcel->getActiveSheet()->getColumnDimension('A')->setWidth(50);
                
                $objPHPExcel->getActiveSheet()->setCellValue('A2', 'ลำดับ');	
                $objPHPExcel->getActiveSheet()->getColumnDimension('A')->setWidth(10);	
                $objPHPExcel->getActiveSheet()->setCellValue('B2', 'รายการ');
                $objPHPExcel->getActiveSheet()->getColumnDimension('B')->setWidth(100);
                $objPHPExcel->getActiveSheet()->setCellValue('C2', 'รอบ');	
                $objPHPExcel->getActiveSheet()->getColumnDimension('C')->setWidth(10);
                $objPHPExcel->getActiveSheet()->setCellValue('D2', 'ตัวตั้ง');	
                $objPHPExcel->getActiveSheet()->getColumnDimension('D')->setWidth(10);
                $objPHPExcel->getActiveSheet()->setCellValue('E2', 'ตัวหาร');	
                $objPHPExcel->getActiveSheet()->getColumnDimension('E')->setWidth(10);
                $objPHPExcel->getActiveSheet()->setCellValue('F2', 'ตัวคูณ');	
                $objPHPExcel->getActiveSheet()->getColumnDimension('F')->setWidth(10);
                $objPHPExcel->getActiveSheet()->setCellValue('G2', 'ผลลัพธ์');	
                $objPHPExcel->getActiveSheet()->getColumnDimension('G')->setWidth(10);
                $objPHPExcel->getActiveSheet()->setCellValue('H2', 'หมายเหตุ');	
                $objPHPExcel->getActiveSheet()->getColumnDimension('H')->setWidth(50);

                $sql = ' select id, dep_name from department';
                $result = DB::select($sql); 

                $row = 2;              
                foreach ($result as $key) 		    
                {	  
                    $i=0;                
                    $objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow (0, $row+1, $key->dep_name);  

                    $sql2  = ' select k2.kpi_name_th, concat(a.around_name," รอบที่ ",k1.around) as aname';
                    $sql2 .= ' ,k1.fraction,k1.section,k1.multiply,k1.result,k1.comment';
                    $sql2 .= ' from kpi_result k1';
                    $sql2 .= ' left join kpi k2 on k2.id=k1.kpi_id';
                    $sql2 .= ' left join around a on a.id=k1.around_id';
                    $sql2 .= ' where k1.created_at between "'.$y1.'" and "'.$y2.'" ';
                    $sql2 .= ' and dep_id = '.$key->id.' order by k2.kpi_name_th asc, k1.around_id asc, k1.around asc';

                    $result2 = DB::select($sql2); 

                    if(count($result2) == 0){
                        $objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow (1, $row+1, '-'); 
                        $row++;	
                    }
                            
                    foreach ($result2 as $key2){ 
                        $i++;
                        $objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow (0, $row+2, $i);	
                        $objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow (1, $row+2, $key2->kpi_name_th); 
                        $objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow (2, $row+2, $key2->aname); 
                        $objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow (3, $row+2, $key2->fraction); 
                        $objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow (4, $row+2, $key2->section); 
                        $objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow (5, $row+2, $key2->multiply); 
                        $objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow (6, $row+2, $key2->result); 
                        $objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow (7, $row+2, $key2->comment); 
                        $row++;	
                    }
                
                    $row++;			    	
                }
            
                $objWriter = PHPExcel_IOFactory::createWriter($objPHPExcel, 'Excel5'); // Set excel version 2007		
                $objWriter->save(storage_path()."/report/reportKpiAll.xls");

                return Response::download( storage_path()."/report/reportKpiAll.xls", "reportKpiAll.xls");	*/
            }
        }else{
            return Redirect::to('login');
        }
    }

}
