<?php

namespace App\Console\Commands;

use App\Models\Opinion;
use Illuminate\Console\Command;
use Illuminate\Support\Str;

class GenerateOpinionSlugs extends Command
{
    protected $signature = 'opinions:generate-slugs';
    protected $description = 'Generate slugs for existing opinions';

    public function handle()
    {
        $this->info('Generating slugs for opinions...');

        Opinion::whereNull('slug')->orWhere('slug', '')->chunk(100, function ($opinions) {
            foreach ($opinions as $opinion) {
                $opinion->slug = Str::slug($opinion->title);
                $opinion->save();
                $this->line("Generated slug for opinion: {$opinion->title}");
            }
        });

        $this->info('Done generating slugs!');
    }
}
