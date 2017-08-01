<?php

use Illuminate\Database\Seeder;

class StatusVendasSeeder extends Seeder
{
    public function run()
    {
        $this->command->info('Iniciando importação StatusVendas');

        DB::table('statusvendas')->insert(
            ['nome' => 'vendido',
             'descricao' => 'A venda foi concluída para um cliente.'
            ],
            ['nome' => 'em andamento',
             'descricao' => 'Um cliente iniciou uma trilha de vendas para este apartamento, mas a venda ainda não foi conclupida nem cancelada'
            ],
            ['nome' => 'cancelado',
             'descricao' => 'Um cliente inicou uma trilha de vendas para este apartamento, mas a venda foi cancelada'
            ]
        );

        $this->command->info('StatusVendas importado com sucesso');
    }

}