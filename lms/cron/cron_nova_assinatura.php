<?php
// ===================================================================
require(dirname(__FILE__).'/../global.php');
$system = new System(false);

$system->load->dao('moip');
$system->load->dao('vendas');
$system->load->dao('planos');
$system->load->model('email_model');
$assinaturasNaoPagas = $system->vendas->buscarPlanosAbertos(true);

foreach ($assinaturasNaoPagas as $venda) {

	try {
		$dados = $system->moip->obterDadosAssinatura($venda['id']);

	} catch(Exception $e)  {
		echo $e->getMessage();
		continue;
	}
	
	if (count($dados['invoices'])) {
		$plano = $dados['invoices'][0];
		//$plano['status']['code'] = 3;
		if ($plano['status']['code'] == 3) {

			$system->vendas->alterarPagamento($venda['id'], 1);
			
			//Adicionar Plano
			$plano = $system->vendas->getPlanoVenda($venda['id']);
			$dataExpiracao = date('Y-m-d', mktime(0, 0, 0, (date('m') + $plano['meses']), date('d'), date('Y')));
			$system->planos->cadastrarPlanoAluno($plano['id'], $venda['aluno_id'], $venda['id'], $dataExpiracao);
			$system->vendas->atualizar($venda['id'], array('data_expiracao' => $dataExpiracao));

			//Emails
			//Administrativo
			$system->email_model->alteradoStatusVendaAdministrativo($venda['numero']);
			
			//Aluno
			$system->email_model->vendaAprovadaAluno($venda['aluno_id'], $venda['numero'], date('d/m/Y', strtotime($dataExpiracao)));

			$system->email_model->assinaturaContratadaAluno($venda['aluno_id'], $plano['plano']);
		} elseif ($plano['status']['code'] == 4) {
			//Cancelada pelo banco emissor
			$system->vendas->alterarPagamento($venda['id'], 2);
		}
	}

}
/*
Status fatura
1	Em aberto				A fatura foi gerada mas ainda não foi paga pelo assinante.
2	Aguardando confirmação	A fatura foi paga pelo assinante, mas o pagamento está em processo de análise de risco.
3	Pago					A fatura foi paga pelo assinante e confirmada.
4	Não pago				O assinante tentou pagar a fatura, mas o pagamento foi negado pelo banco emissor do cartão de crédito ou a análise de risco detectou algum problema. Veja os motivos possíveis.
5	Atrasada				O pagamento da fatura foi cancelado e serão feitas novas tentativas de cobrança de acordo com a configuração de retentativa automática.
*/