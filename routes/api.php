<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\weatherdetailsController;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/

Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});

Route::post('/storeforcast', [weatherdetailsController::class,'store']);
Route::get('/latestlimited', [weatherdetailsController::class,'index']);
Route::get('/delete/{id}', [weatherdetailsController::class,'destroy']);
Route::post('/updatedata/{id}', [weatherdetailsController::class,'update']);
Route::get('/searchlocation/{location}', [weatherdetailsController::class,'search']);
Route::get('/searcharea/{location?}', [weatherdetailsController::class,'searchlocation']);
Route::post('/adminsearch', [weatherdetailsController::class,'adminsearch']);
Route::post('/fileimport', [weatherdetailsController::class, 'fileImport']);
Route::post('/fileexport', [weatherdetailsController::class, 'fileExport']);



// deletedata(){
//     let arr = []
//     let axiosarray = []
//     let checkeddata2 = this.checkeddata
//     if (confirm('All selection(s) will be deleted/distroyed(Permanently)')){
//         checkeddata2.forEach(data => 
//         {var newpromise = axios.get('/api/delete/'+ data)
//             axiosarray.push(newpromise)
//         })
//         axios.all(axiosarray)
//         .then(axios.spread((...responses) =>{ 
//             responses.forEach(res =>arr.push(res.data)
//             )
//             if(arr.length == checkeddata2.length){
//                 console.log('success')
//             }                     
//         })).catch(error => {
//             console.log(error);
//         }) 
//     }else{
//         console.log('cancelled')
//     }
// },

