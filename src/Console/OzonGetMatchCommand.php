<?php
namespace Islomzoda\OzonUpdateStock\Console;
use Illuminate\Console\Command;
use Islomzoda\OzonUpdateStock\Api\OzonProductMatch;

class OzonGetMatchCommand extends Command
{
    protected $signature = 'ozon:match';
    protected $description = 'Данная команда будеть загружат сопоставление из Озон';
    public function handle(){
        (new OzonProductMatch())->getMath();
    }
}
