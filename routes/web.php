<?php
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\QuestaoController;
use App\Http\Controllers\QuestoesDisciplinasController;
use App\Http\Controllers\QuestoesPorDisciplinasController;
use App\Http\Controllers\ListaCadernosController;
use App\Http\Controllers\QuestoesNumeroLivroController;
use App\Http\Controllers\QuestoesRespostasController;
use App\Http\Controllers\ComentarioQuestoesController;
use App\Http\Controllers\PesquisaQuestaoController;
use App\Http\Controllers\NomeBancaController;
use App\Http\Controllers\AssuntoController;
/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "web" middleware group. Make something great!
|
*/




//Route::get('/disciplinas', [QuestoesDisciplinasController::class,'index']);

//Route::get('/questoes-por-disciplinas', [QuestoesPorDisciplinasController::class, 'index']);

//Route::get('/cadernos',[ListaCadernosController::class,'index']);

//Route::get('/questoes-numero-livro', [QuestoesNumeroLivroController::class, 'index']);

//Route::post('/questoes-respostas', [QuestoesRespostasController::class, 'store']);

//Route::post('/comentario-questoes', [ComentarioQuestoesController::class, 'store']);
//Route::post('/Pesquisa-questao', [PesquisaQuestaoController::class, 'store']);





Route::get('/disciplina', function () {
    $controller = new QuestoesDisciplinasController();
    return $controller->index()->header('Access-Control-Allow-Origin', '*');
});


Route::get('/questao', function () {
    $controller = new QuestoesPorDisciplinasController();
    return $controller->index()->header('Access-Control-Allow-Origin', '*');
});


Route::get('/cadernos', function () {
    $controller = new ListaCadernosController();
    return $controller->index()->header('Access-Control-Allow-Origin', '*');
});


Route::get('/questoes-numero-livro', function () {
    $controller = new QuestoesNumeroLivroController();
    return $controller->index()->header('Access-Control-Allow-Origin', '*');
});




Route::post('/comentario-questoes', function (Request $request) {
    $controller = new ComentarioQuestoesController();
    return $controller->store($request)->header('Access-Control-Allow-Origin', '*');
});


Route::post('/pesquisa-questao', function (Request $request) {
    $controller = new PesquisaQuestaoController();
    return $controller->palavraChave($request)->header('Access-Control-Allow-Origin', '*');
});

Route::post('/resposta', function(Request $request)
{
    $controller = new PesquisaQuestaoController();
    return   $controller->resposta($request)->header('Access-Control-Allow-Origin','*');
});

Route::post('/comentario-aluno', function(Request $request)
{
    $controller = new PesquisaQuestaoController();
    return $controller->comentarioAluno($request)->header('Access-Control-Allow-Origin','*');
});

Route::post('/comentario-gabarito', function(Request $request) {
    $controller = new PesquisaQuestaoController();
    return $controller->comentarioGabarito($request)->header('Access-Control-Allow-Origin','*');
});










// rotas pedidas pelo thomas
Route::get('/banca', function () {
    $controller = new NomeBancaController();
    return $controller->index()->header('Access-Control-Allow-Origin','*');
});


Route::get('/assunto', function () {
    $controller = new PesquisaQuestaoController();
    return $controller->assunto()->header('Access-Control-Allow-Origin','*');
});

Route::get('/exibir-questoes', function (Request $request) {
    $controller = new PesquisaQuestaoController();
    return $controller->index($request)->header('Access-Control-Allow-Origin','*');
});

Route::get('/instituicao', function() {
    $controller = new PesquisaQuestaoController();
    return $controller->instituicao()->header('Access-Control-Allow-Origin', '*');
});


Route::get('/ano', function() {
    $controller = new PesquisaQuestaoController();
    return $controller->anoQuestao()->header('Access-Control-Allow-Origin', '*');
});


Route::get('/area-formacao', function()
{
    $controller = new QuestoesDisciplinasController();
    return $controller->areaFormacao()->header('Access-Control-Allow-Origin', '*');
});

Route::get('/dificuldade', function()
{
    $controller = new PesquisaQuestaoController();
    return $controller->dificuldade()->header('Access-Control-Allow-Origin', '*');
});

Route::post('/palavra-chave',function(Request $request)
{
    $controller = new QuestoesPorDisciplinasController();
    return $controller->palavraChave($request)->header('Access-Control-Allow-Origin', '*');
});


Route::get('', function (){
    return view('welcome');
});
