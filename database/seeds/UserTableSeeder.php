<?php

use Illuminate\Database\Seeder;

class UserTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $user = new \App\User();
		$user->name = 'Administrador';
		$user->email = 'admin@admin.com';
		$user->password = bcrypt('123456');
		$user->permissao = 1;
		$user->telefone = '(51) 99965.2705';
		$user->endereco = 'Av Brasil, 1965';
		$user->observacoes = '';
		$user->cpf_cnpj = '00000000000';
		$user->cidade_id = 4464;
		$user->imobiliaria_id = 1;
		$user->save();

        $this->command->info('Usuários importados com sucesso!');
    }
}
