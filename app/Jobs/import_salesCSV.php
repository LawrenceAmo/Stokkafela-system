<?php
namespace App\Jobs;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use Illuminate\Support\Facades\DB;

class import_salesCSV implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    public $data;
    public $header;
    public $form;
  
    public function __construct($data, $header, $form)
    {
        $this->data = $data;
        $this->header = $header;
        $this->form = $form;
    }

    public function handle()
    {
        if (!$this->form['isDailyTotals']) {
            DB::table('sales')
            ->where([
                    ['from', 'LIKE', $this->form['date_from'].'%'],
                    ['storeID', intval($this->form['store'])],
                    ['daily_total', '=', false],
                    ])
            ->delete();
        }
 
        for ($i=0; $i <count($this->data); $i++) {
          
            if ($this->form['isDailyTotals'] || $this->form['isDailyTotals'] != null) {
                $date = (int)$this->data[$i][$this->header['date']];
                $date = \PhpOffice\PhpSpreadsheet\Shared\Date::excelToTimestamp( $date );
                $date_from = date('Y-m-d', $date );
                $date_to = date('Y-m-d', $date );
                $isDailyTotals = true;
            }else{
                $date_from = $this->form['date_from'];
                $date_to = $this->form['date_from'];    //need to be changed
                $isDailyTotals = false;
            }

            $code = $this->data[$i][$this->header['code']];

            if (!$code) {
                $code = 0;
            }
 
            $sales = [
                'code' => $code,
                'descript' => $this->data[$i][$this->header['descript']],
                'mainitem' => $this->data[$i][$this->header['mainitem']],
                'department' => $this->data[$i][$this->header['department']],
                'sales' => $this->data[$i][$this->header['sales']],
                'salescost' => $this->data[$i][$this->header['salescost']],
                'refund' => $this->data[$i][$this->header['refund']],
                'refundscost' => $this->data[$i][$this->header['refundscost']],
                'nettsales' => $this->data[$i][$this->header['nettsales']],
                'profit' => $this->data[$i][$this->header['profit']],
                'vat' => $this->data[$i][$this->header['vat']],
                'isDailyTotals' => $isDailyTotals,
                'date_from' => $date_from,
                'date_to' => $date_to,
             ];
            save_imported_salesCSV::dispatch($sales, $this->form); 
        }
    }
}
 
// PDOException: SQLSTATE[22007]: Invalid datetime format: 1292 Truncated incorrect DOUBLE value: 'Date' in C:\Users\ubuntu\Documents\My Projects\Clients\Stokkafela-system\vendor\laravel\framework\src\Illuminate\Database\Connection.php:570
// Stack trace:
#0 C:\Users\ubuntu\Documents\My Projects\Clients\Stokkafela-system\vendor\laravel\framework\src\Illuminate\Database\Connection.php(570): PDOStatement->execute()
#1 C:\Users\ubuntu\Documents\My Projects\Clients\Stokkafela-system\vendor\laravel\framework\src\Illuminate\Database\Connection.php(753): Illuminate\Database\Connection->Illuminate\Database\{closure}('update `sales` ...', Array)
#2 C:\Users\ubuntu\Documents\My Projects\Clients\Stokkafela-system\vendor\laravel\framework\src\Illuminate\Database\Connection.php(720): Illuminate\Database\Connection->runQueryCallback('update `sales` ...', Array, Object(Closure))
#3 C:\Users\ubuntu\Documents\My Projects\Clients\Stokkafela-system\vendor\laravel\framework\src\Illuminate\Database\Connection.php(577): Illuminate\Database\Connection->run('update `sales` ...', Array, Object(Closure))
#4 C:\Users\ubuntu\Documents\My Projects\Clients\Stokkafela-system\vendor\laravel\framework\src\Illuminate\Database\Connection.php(510): Illuminate\Database\Connection->affectingStatement('update `sales` ...', Array)
#5 C:\Users\ubuntu\Documents\My Projects\Clients\Stokkafela-system\vendor\laravel\framework\src\Illuminate\Database\Query\Builder.php(3301): Illuminate\Database\Connection->update('update `sales` ...', Array)
#6 C:\Users\ubuntu\Documents\My Projects\Clients\Stokkafela-system\app\Jobs\save_imported_salesCSV.php(89): Illuminate\Database\Query\Builder->update(Array)
#7 C:\Users\ubuntu\Documents\My Projects\Clients\Stokkafela-system\vendor\laravel\framework\src\Illuminate\Container\BoundMethod.php(36): App\Jobs\save_imported_salesCSV->handle()
#8 C:\Users\ubuntu\Documents\My Projects\Clients\Stokkafela-system\vendor\laravel\framework\src\Illuminate\Container\Util.php(41): Illuminate\Container\BoundMethod::Illuminate\Container\{closure}()
#9 C:\Users\ubuntu\Documents\My Projects\Clients\Stokkafela-system\vendor\laravel\framework\src\Illuminate\Container\BoundMethod.php(93): Illuminate\Container\Util::unwrapIfClosure(Object(Closure))
#10 C:\Users\ubuntu\Documents\My Projects\Clients\Stokkafela-system\vendor\laravel\framework\src\Illuminate\Container\BoundMethod.php(37): Illuminate\Container\BoundMethod::callBoundMethod(Object(Illuminate\Foundation\Application), Array, Object(Closure))
#11 C:\Users\ubuntu\Documents\My Projects\Clients\Stokkafela-system\vendor\laravel\framework\src\Illuminate\Container\Container.php(651): Illuminate\Container\BoundMethod::call(Object(Illuminate\Foundation\Application), Array, Array, NULL)
#12 C:\Users\ubuntu\Documents\My Projects\Clients\Stokkafela-system\vendor\laravel\framework\src\Illuminate\Bus\Dispatcher.php(128): Illuminate\Container\Container->call(Array)
#13 C:\Users\ubuntu\Documents\My Projects\Clients\Stokkafela-system\vendor\laravel\framework\src\Illuminate\Pipeline\Pipeline.php(141): Illuminate\Bus\Dispatcher->Illuminate\Bus\{closure}(Object(App\Jobs\save_imported_salesCSV))
#14 C:\Users\ubuntu\Documents\My Projects\Clients\Stokkafela-system\vendor\laravel\framework\src\Illuminate\Pipeline\Pipeline.php(116): Illuminate\Pipeline\Pipeline->Illuminate\Pipeline\{closure}(Object(App\Jobs\save_imported_salesCSV))
#15 C:\Users\ubuntu\Documents\My Projects\Clients\Stokkafela-system\vendor\laravel\framework\src\Illuminate\Bus\Dispatcher.php(132): Illuminate\Pipeline\Pipeline->then(Object(Closure))
#16 C:\Users\ubuntu\Documents\My Projects\Clients\Stokkafela-system\vendor\laravel\framework\src\Illuminate\Queue\CallQueuedHandler.php(124): Illuminate\Bus\Dispatcher->dispatchNow(Object(App\Jobs\save_imported_salesCSV), false)
#17 C:\Users\ubuntu\Documents\My Projects\Clients\Stokkafela-system\vendor\laravel\framework\src\Illuminate\Pipeline\Pipeline.php(141): Illuminate\Queue\CallQueuedHandler->Illuminate\Queue\{closure}(Object(App\Jobs\save_imported_salesCSV))
#18 C:\Users\ubuntu\Documents\My Projects\Clients\Stokkafela-system\vendor\laravel\framework\src\Illuminate\Pipeline\Pipeline.php(116): Illuminate\Pipeline\Pipeline->Illuminate\Pipeline\{closure}(Object(App\Jobs\save_imported_salesCSV))
#19 C:\Users\ubuntu\Documents\My Projects\Clients\Stokkafela-system\vendor\laravel\framework\src\Illuminate\Queue\CallQueuedHandler.php(126): Illuminate\Pipeline\Pipeline->then(Object(Closure))
#20 C:\Users\ubuntu\Documents\My Projects\Clients\Stokkafela-system\vendor\laravel\framework\src\Illuminate\Queue\CallQueuedHandler.php(70): Illuminate\Queue\CallQueuedHandler->dispatchThroughMiddleware(Object(Illuminate\Queue\Jobs\DatabaseJob), Object(App\Jobs\save_imported_salesCSV))
#21 C:\Users\ubuntu\Documents\My Projects\Clients\Stokkafela-system\vendor\laravel\framework\src\Illuminate\Queue\Jobs\Job.php(98): Illuminate\Queue\CallQueuedHandler->call(Object(Illuminate\Queue\Jobs\DatabaseJob), Array)
#22 C:\Users\ubuntu\Documents\My Projects\Clients\Stokkafela-system\vendor\laravel\framework\src\Illuminate\Queue\Worker.php(425): Illuminate\Queue\Jobs\Job->fire()
#23 C:\Users\ubuntu\Documents\My Projects\Clients\Stokkafela-system\vendor\laravel\framework\src\Illuminate\Queue\Worker.php(375): Illuminate\Queue\Worker->process('database', Object(Illuminate\Queue\Jobs\DatabaseJob), Object(Illuminate\Queue\WorkerOptions))
#24 C:\Users\ubuntu\Documents\My Projects\Clients\Stokkafela-system\vendor\laravel\framework\src\Illuminate\Queue\Worker.php(173): Illuminate\Queue\Worker->runJob(Object(Illuminate\Queue\Jobs\DatabaseJob), 'database', Object(Illuminate\Queue\WorkerOptions))
#25 C:\Users\ubuntu\Documents\My Projects\Clients\Stokkafela-system\vendor\laravel\framework\src\Illuminate\Queue\Console\WorkCommand.php(146): Illuminate\Queue\Worker->daemon('database', 'default', Object(Illuminate\Queue\WorkerOptions))
#26 C:\Users\ubuntu\Documents\My Projects\Clients\Stokkafela-system\vendor\laravel\framework\src\Illuminate\Queue\Console\WorkCommand.php(130): Illuminate\Queue\Console\WorkCommand->runWorker('database', 'default')
#27 C:\Users\ubuntu\Documents\My Projects\Clients\Stokkafela-system\vendor\laravel\framework\src\Illuminate\Container\BoundMethod.php(36): Illuminate\Queue\Console\WorkCommand->handle()
#28 C:\Users\ubuntu\Documents\My Projects\Clients\Stokkafela-system\vendor\laravel\framework\src\Illuminate\Container\Util.php(41): Illuminate\Container\BoundMethod::Illuminate\Container\{closure}()
#29 C:\Users\ubuntu\Documents\My Projects\Clients\Stokkafela-system\vendor\laravel\framework\src\Illuminate\Container\BoundMethod.php(93): Illuminate\Container\Util::unwrapIfClosure(Object(Closure))
#30 C:\Users\ubuntu\Documents\My Projects\Clients\Stokkafela-system\vendor\laravel\framework\src\Illuminate\Container\BoundMethod.php(37): Illuminate\Container\BoundMethod::callBoundMethod(Object(Illuminate\Foundation\Application), Array, Object(Closure))
#31 C:\Users\ubuntu\Documents\My Projects\Clients\Stokkafela-system\vendor\laravel\framework\src\Illuminate\Container\Container.php(651): Illuminate\Container\BoundMethod::call(Object(Illuminate\Foundation\Application), Array, Array, NULL)
#32 C:\Users\ubuntu\Documents\My Projects\Clients\Stokkafela-system\vendor\laravel\framework\src\Illuminate\Console\Command.php(182): Illuminate\Container\Container->call(Array)
#33 C:\Users\ubuntu\Documents\My Projects\Clients\Stokkafela-system\vendor\symfony\console\Command\Command.php(312): Illuminate\Console\Command->execute(Object(Symfony\Component\Console\Input\ArgvInput), Object(Illuminate\Console\OutputStyle))
#34 C:\Users\ubuntu\Documents\My Projects\Clients\Stokkafela-system\vendor\laravel\framework\src\Illuminate\Console\Command.php(152): Symfony\Component\Console\Command\Command->run(Object(Symfony\Component\Console\Input\ArgvInput), Object(Illuminate\Console\OutputStyle))
#35 C:\Users\ubuntu\Documents\My Projects\Clients\Stokkafela-system\vendor\symfony\console\Application.php(1022): Illuminate\Console\Command->run(Object(Symfony\Component\Console\Input\ArgvInput), Object(Symfony\Component\Console\Output\ConsoleOutput))
#36 C:\Users\ubuntu\Documents\My Projects\Clients\Stokkafela-system\vendor\symfony\console\Application.php(314): Symfony\Component\Console\Application->doRunCommand(Object(Illuminate\Queue\Console\WorkCommand), Object(Symfony\Component\Console\Input\ArgvInput), Object(Symfony\Component\Console\Output\ConsoleOutput))
#37 C:\Users\ubuntu\Documents\My Projects\Clients\Stokkafela-system\vendor\symfony\console\Application.php(168): Symfony\Component\Console\Application->doRun(Object(Symfony\Component\Console\Input\ArgvInput), Object(Symfony\Component\Console\Output\ConsoleOutput))
#38 C:\Users\ubuntu\Documents\My Projects\Clients\Stokkafela-system\vendor\laravel\framework\src\Illuminate\Console\Application.php(102): Symfony\Component\Console\Application->run(Object(Symfony\Component\Console\Input\ArgvInput), Object(Symfony\Component\Console\Output\ConsoleOutput))
#39 C:\Users\ubuntu\Documents\My Projects\Clients\Stokkafela-system\vendor\laravel\framework\src\Illuminate\Foundation\Console\Kernel.php(155): Illuminate\Console\Application->run(Object(Symfony\Component\Console\Input\ArgvInput), Object(Symfony\Component\Console\Output\ConsoleOutput))
#40 C:\Users\ubuntu\Documents\My Projects\Clients\Stokkafela-system\artisan(37): Illuminate\Foundation\Console\Kernel->handle(Object(Symfony\Component\Console\Input\ArgvInput), Object(Symfony\Component\Console\Output\ConsoleOutput))
#41 {main}

// Next Illuminate\Database\QueryException: SQLSTATE[22007]: Invalid datetime format: 1292 Truncated incorrect DOUBLE value: 'Date' (SQL: update `sales` set `sales` = 2,333, `salesCost` = 1,618, `reFunds` = 0, `reFundsCost` = 0, `nettSales` = 2,333, `profit` = 716, `vat` = 350 where (`barcode` = 44940 and `from` LIKE 2023-01-01% and `to` = 2023-01-01% and `daily_total` = 1 and `storeID` = 18)) in C:\Users\ubuntu\Documents\My Projects\Clients\Stokkafela-system\vendor\laravel\framework\src\Illuminate\Database\Connection.php:760
// Stack trace:
#0 C:\Users\ubuntu\Documents\My Projects\Clients\Stokkafela-system\vendor\laravel\framework\src\Illuminate\Database\Connection.php(720): Illuminate\Database\Connection->runQueryCallback('update `sales` ...', Array, Object(Closure))
#1 C:\Users\ubuntu\Documents\My Projects\Clients\Stokkafela-system\vendor\laravel\framework\src\Illuminate\Database\Connection.php(577): Illuminate\Database\Connection->run('update `sales` ...', Array, Object(Closure))
#2 C:\Users\ubuntu\Documents\My Projects\Clients\Stokkafela-system\vendor\laravel\framework\src\Illuminate\Database\Connection.php(510): Illuminate\Database\Connection->affectingStatement('update `sales` ...', Array)
#3 C:\Users\ubuntu\Documents\My Projects\Clients\Stokkafela-system\vendor\laravel\framework\src\Illuminate\Database\Query\Builder.php(3301): Illuminate\Database\Connection->update('update `sales` ...', Array)
#4 C:\Users\ubuntu\Documents\My Projects\Clients\Stokkafela-system\app\Jobs\save_imported_salesCSV.php(89): Illuminate\Database\Query\Builder->update(Array)
#5 C:\Users\ubuntu\Documents\My Projects\Clients\Stokkafela-system\vendor\laravel\framework\src\Illuminate\Container\BoundMethod.php(36): App\Jobs\save_imported_salesCSV->handle()
#6 C:\Users\ubuntu\Documents\My Projects\Clients\Stokkafela-system\vendor\laravel\framework\src\Illuminate\Container\Util.php(41): Illuminate\Container\BoundMethod::Illuminate\Container\{closure}()
#7 C:\Users\ubuntu\Documents\My Projects\Clients\Stokkafela-system\vendor\laravel\framework\src\Illuminate\Container\BoundMethod.php(93): Illuminate\Container\Util::unwrapIfClosure(Object(Closure))
#8 C:\Users\ubuntu\Documents\My Projects\Clients\Stokkafela-system\vendor\laravel\framework\src\Illuminate\Container\BoundMethod.php(37): Illuminate\Container\BoundMethod::callBoundMethod(Object(Illuminate\Foundation\Application), Array, Object(Closure))
#9 C:\Users\ubuntu\Documents\My Projects\Clients\Stokkafela-system\vendor\laravel\framework\src\Illuminate\Container\Container.php(651): Illuminate\Container\BoundMethod::call(Object(Illuminate\Foundation\Application), Array, Array, NULL)
#10 C:\Users\ubuntu\Documents\My Projects\Clients\Stokkafela-system\vendor\laravel\framework\src\Illuminate\Bus\Dispatcher.php(128): Illuminate\Container\Container->call(Array)
#11 C:\Users\ubuntu\Documents\My Projects\Clients\Stokkafela-system\vendor\laravel\framework\src\Illuminate\Pipeline\Pipeline.php(141): Illuminate\Bus\Dispatcher->Illuminate\Bus\{closure}(Object(App\Jobs\save_imported_salesCSV))
#12 C:\Users\ubuntu\Documents\My Projects\Clients\Stokkafela-system\vendor\laravel\framework\src\Illuminate\Pipeline\Pipeline.php(116): Illuminate\Pipeline\Pipeline->Illuminate\Pipeline\{closure}(Object(App\Jobs\save_imported_salesCSV))
#13 C:\Users\ubuntu\Documents\My Projects\Clients\Stokkafela-system\vendor\laravel\framework\src\Illuminate\Bus\Dispatcher.php(132): Illuminate\Pipeline\Pipeline->then(Object(Closure))
#14 C:\Users\ubuntu\Documents\My Projects\Clients\Stokkafela-system\vendor\laravel\framework\src\Illuminate\Queue\CallQueuedHandler.php(124): Illuminate\Bus\Dispatcher->dispatchNow(Object(App\Jobs\save_imported_salesCSV), false)
#15 C:\Users\ubuntu\Documents\My Projects\Clients\Stokkafela-system\vendor\laravel\framework\src\Illuminate\Pipeline\Pipeline.php(141): Illuminate\Queue\CallQueuedHandler->Illuminate\Queue\{closure}(Object(App\Jobs\save_imported_salesCSV))
#16 C:\Users\ubuntu\Documents\My Projects\Clients\Stokkafela-system\vendor\laravel\framework\src\Illuminate\Pipeline\Pipeline.php(116): Illuminate\Pipeline\Pipeline->Illuminate\Pipeline\{closure}(Object(App\Jobs\save_imported_salesCSV))
#17 C:\Users\ubuntu\Documents\My Projects\Clients\Stokkafela-system\vendor\laravel\framework\src\Illuminate\Queue\CallQueuedHandler.php(126): Illuminate\Pipeline\Pipeline->then(Object(Closure))
#18 C:\Users\ubuntu\Documents\My Projects\Clients\Stokkafela-system\vendor\laravel\framework\src\Illuminate\Queue\CallQueuedHandler.php(70): Illuminate\Queue\CallQueuedHandler->dispatchThroughMiddleware(Object(Illuminate\Queue\Jobs\DatabaseJob), Object(App\Jobs\save_imported_salesCSV))
#19 C:\Users\ubuntu\Documents\My Projects\Clients\Stokkafela-system\vendor\laravel\framework\src\Illuminate\Queue\Jobs\Job.php(98): Illuminate\Queue\CallQueuedHandler->call(Object(Illuminate\Queue\Jobs\DatabaseJob), Array)
#20 C:\Users\ubuntu\Documents\My Projects\Clients\Stokkafela-system\vendor\laravel\framework\src\Illuminate\Queue\Worker.php(425): Illuminate\Queue\Jobs\Job->fire()
#21 C:\Users\ubuntu\Documents\My Projects\Clients\Stokkafela-system\vendor\laravel\framework\src\Illuminate\Queue\Worker.php(375): Illuminate\Queue\Worker->process('database', Object(Illuminate\Queue\Jobs\DatabaseJob), Object(Illuminate\Queue\WorkerOptions))
#22 C:\Users\ubuntu\Documents\My Projects\Clients\Stokkafela-system\vendor\laravel\framework\src\Illuminate\Queue\Worker.php(173): Illuminate\Queue\Worker->runJob(Object(Illuminate\Queue\Jobs\DatabaseJob), 'database', Object(Illuminate\Queue\WorkerOptions))
#23 C:\Users\ubuntu\Documents\My Projects\Clients\Stokkafela-system\vendor\laravel\framework\src\Illuminate\Queue\Console\WorkCommand.php(146): Illuminate\Queue\Worker->daemon('database', 'default', Object(Illuminate\Queue\WorkerOptions))
#24 C:\Users\ubuntu\Documents\My Projects\Clients\Stokkafela-system\vendor\laravel\framework\src\Illuminate\Queue\Console\WorkCommand.php(130): Illuminate\Queue\Console\WorkCommand->runWorker('database', 'default')
#25 C:\Users\ubuntu\Documents\My Projects\Clients\Stokkafela-system\vendor\laravel\framework\src\Illuminate\Container\BoundMethod.php(36): Illuminate\Queue\Console\WorkCommand->handle()
#26 C:\Users\ubuntu\Documents\My Projects\Clients\Stokkafela-system\vendor\laravel\framework\src\Illuminate\Container\Util.php(41): Illuminate\Container\BoundMethod::Illuminate\Container\{closure}()
#27 C:\Users\ubuntu\Documents\My Projects\Clients\Stokkafela-system\vendor\laravel\framework\src\Illuminate\Container\BoundMethod.php(93): Illuminate\Container\Util::unwrapIfClosure(Object(Closure))
#28 C:\Users\ubuntu\Documents\My Projects\Clients\Stokkafela-system\vendor\laravel\framework\src\Illuminate\Container\BoundMethod.php(37): Illuminate\Container\BoundMethod::callBoundMethod(Object(Illuminate\Foundation\Application), Array, Object(Closure))
#29 C:\Users\ubuntu\Documents\My Projects\Clients\Stokkafela-system\vendor\laravel\framework\src\Illuminate\Container\Container.php(651): Illuminate\Container\BoundMethod::call(Object(Illuminate\Foundation\Application), Array, Array, NULL)
#30 C:\Users\ubuntu\Documents\My Projects\Clients\Stokkafela-system\vendor\laravel\framework\src\Illuminate\Console\Command.php(182): Illuminate\Container\Container->call(Array)
#31 C:\Users\ubuntu\Documents\My Projects\Clients\Stokkafela-system\vendor\symfony\console\Command\Command.php(312): Illuminate\Console\Command->execute(Object(Symfony\Component\Console\Input\ArgvInput), Object(Illuminate\Console\OutputStyle))
#32 C:\Users\ubuntu\Documents\My Projects\Clients\Stokkafela-system\vendor\laravel\framework\src\Illuminate\Console\Command.php(152): Symfony\Component\Console\Command\Command->run(Object(Symfony\Component\Console\Input\ArgvInput), Object(Illuminate\Console\OutputStyle))
#33 C:\Users\ubuntu\Documents\My Projects\Clients\Stokkafela-system\vendor\symfony\console\Application.php(1022): Illuminate\Console\Command->run(Object(Symfony\Component\Console\Input\ArgvInput), Object(Symfony\Component\Console\Output\ConsoleOutput))
#34 C:\Users\ubuntu\Documents\My Projects\Clients\Stokkafela-system\vendor\symfony\console\Application.php(314): Symfony\Component\Console\Application->doRunCommand(Object(Illuminate\Queue\Console\WorkCommand), Object(Symfony\Component\Console\Input\ArgvInput), Object(Symfony\Component\Console\Output\ConsoleOutput))
#35 C:\Users\ubuntu\Documents\My Projects\Clients\Stokkafela-system\vendor\symfony\console\Application.php(168): Symfony\Component\Console\Application->doRun(Object(Symfony\Component\Console\Input\ArgvInput), Object(Symfony\Component\Console\Output\ConsoleOutput))
#36 C:\Users\ubuntu\Documents\My Projects\Clients\Stokkafela-system\vendor\laravel\framework\src\Illuminate\Console\Application.php(102): Symfony\Component\Console\Application->run(Object(Symfony\Component\Console\Input\ArgvInput), Object(Symfony\Component\Console\Output\ConsoleOutput))
#37 C:\Users\ubuntu\Documents\My Projects\Clients\Stokkafela-system\vendor\laravel\framework\src\Illuminate\Foundation\Console\Kernel.php(155): Illuminate\Console\Application->run(Object(Symfony\Component\Console\Input\ArgvInput), Object(Symfony\Component\Console\Output\ConsoleOutput))
#38 C:\Users\ubuntu\Documents\My Projects\Clients\Stokkafela-system\artisan(37): Illuminate\Foundation\Console\Kernel->handle(Object(Symfony\Component\Console\Input\ArgvInput), Object(Symfony\Component\Console\Output\ConsoleOutput))
#39 {main}