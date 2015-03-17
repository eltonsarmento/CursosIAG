<?php
// ===================================================================
require(dirname(__FILE__).'/../global.php');
$system = new System(false);

$system->load->dao('moip');
$system->load->dao('vendas');
$system->load->dao('planos');
$system->load->model('email_model');
$planosRenovar = $system->planos->buscarPlanosRenovar();

foreach ($planosRenovar as $planos) {

	try {
		$dados = $system->moip->obterDadosAssinatura($planos['assinatura_id']);

	} catch(Exception $e)  {
		echo $e->getMessage();
		continue;
	}
	
	if (count($dados['invoices'])) {
		$plano = $dados['invoices'][0];
		$plano['status']['code'] = 3;
		if ($plano['status']['code'] == 3) { //Renovar

			$plano = $system->planos->getPlano($planos['plano_id']);
			$dataExpiracao = date('Y-m-d', mktime(0, 0, 0, (date('m') + $plano['meses']), date('d'), date('Y')));

			$campos = array(
				'usuario_id'		=> 0,
				'aluno_id'			=> $planos['usuario_id'],
				'cupom_id'			=> 0,
				'parceiro_id'		=> 0,
				'forma_desconto'	=> 0,
				'forma_pagamento'	=> 0,
				'status'			=> 1,
				'valor_desconto'	=> 0,
				'valor_total'		=> $plano['valor'],
				'data_venda'		=> date('d/m/Y'),
				'data_expiracao'	=> $dataExpiracao,
				'cursos'			=> array(),
				'planos'			=> array($plano['id']),
			);
		
			$id = $system->vendas->cadastrar($campos);
		
			$system->planos->renovarAssinatura($planos['id'], $dataExpiracao);
			$system->planos->renovarCursoPlano($planos['curso_id'], $dataExpiracao);

			//Aluno
			$system->email_model->assinaturaRenovadaAluno($planos['usuario_id'], $plano['nome']);

		} elseif ($plano['status']['code'] == 4 || $plano['status']['code'] == 5) { //Cancelar tentativas
			$plano = $system->planos->getPlano($planos['plano_id']);

			$system->planos->desativarAssinatura($planos['id']);

			//Aluno
			$system->email_model->assinaturaNaoRenovadaAluno($planos['usuario_id'], $plano['nome']);

			$system->moip->suspenderAssinatura($planos['assinatura_id']);
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