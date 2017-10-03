<?php

use Illuminate\Database\Seeder;

class ImobiliariaTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $registro = new \App\Imobiliaria();
		$registro->nome = 'Local/independente';
		$registro->telefone = '(47) 9999.8888';
		$registro->email = 'contato@endereco.com.br';
		$registro->endereco = 'N/A';
		$registro->cidade_id = 4464;
		$registro->save();

        $this->command->info('Imobiliárias importadas com sucesso!');
    }
}
