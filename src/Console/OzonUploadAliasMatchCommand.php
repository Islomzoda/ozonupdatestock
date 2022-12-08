<?php
namespace Islomzoda\OzonUpdateStock\Console;
use Illuminate\Console\Command;
use Islomzoda\OzonUpdateStock\Api\OzonProductMatch;

class OzonUploadAliasMatchCommand extends Command
{
    protected $signature = 'ozon:alias';
    protected $description = 'Данная команда будеть загружат сопоставление для Озон';
    public function handle(){
        (new OzonProductMatch())->uploadAlias();
    }
}
