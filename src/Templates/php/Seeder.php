<?php

use App\Models\¤ModelP¤;
use Illuminate\Database\Seeder;

class ¤ModelP¤Seeder extends Seeder
{
    private $amount = 25;

    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $file_name = __DIR__ . "/¤_models¤.csv";

        // Import from CSV
        if (file_exists($file_name)) {
            $¤modelsC¤ = new ¤ModelP¤;
            $row = 0;
            if (($handle = fopen($file_name, "r")) !== false) {
                $this->command->line(PHP_EOL.'Importing ¤ModelsP¤ from '.$file_name);
                $bar = $this->command->getOutput()->createProgressBar(count(file($file_name)));
                $bar->start();
                while (($data = fgetcsv($handle, 100, ";")) !== false) {
                    $row++;
                    if ($row == 1) {
                        continue;
                    }
                    $¤modelsC¤->create([
                        'id' => $data[0],
                    ]);
                    $bar->advance();
                }
                fclose($handle);
            }
            $bar->finish();
            $this->command->line(PHP_EOL.'¤ModelsP¤ import complete!');
        }

        // Generate random models from factory
        $this->command->line(PHP_EOL.'Generating ' . $this->amount . ' random ¤ModelsP¤ from Factory');
        $bar = $this->command->getOutput()->createProgressBar($this->amount);
        $bar->start();
        for ($i = 0; $i < $this->amount; $i++) {
            factory(¤ModelP¤::class)->create();
            $bar->advance();
        }
        $bar->finish();
        $this->command->line(PHP_EOL.'¤ModelsP¤ import complete!');
    }
}