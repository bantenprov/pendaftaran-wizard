<?php

use Illuminate\Database\Seeder;

class BantenprovPendaftaranWizardSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
         $this->call(BantenprovPendaftaranWizardSeederPendaftaranWizard::class);
    }
}
