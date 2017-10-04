<?php

use Illuminate\Database\Seeder;

class StatusEtapasTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $registro = new \App\StatusEtapa();
		$registro->nome = 'Completa';
		$registro->descricao = '';
		$registro->save();
       
        $registro = new \App\StatusEtapa();
		$registro->nome = 'Em andamento';
		$registro->descricao = '';
		$registro->save();
       
        $registro = new \App\StatusEtapa();
		$registro->nome = 'Em espera';
		$registro->descricao = '';
		$registro->save();
       
        $this->command->info('Status de etapas importados com sucesso!');
    }
}
