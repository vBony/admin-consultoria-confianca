<?php
global $routes;
$routes = array();
$routes['/usuario/criar-codigo'] = '/usuario/criarCodigo';
$routes['/usuario/codigos-disponiveis'] = '/usuario/codigosDisponiveis';
$routes['/api/solicitacao/buscar'] = '/solicitacao/buscar';
$routes['/solicitacao/{id}'] = '/solicitacao/id/:id';
$routes['/pagina-nao-encontrada'] = '/nao-encontrado';
$routes['/api/auth/id'] = '/auth/id';
$routes['/api/solicitacao/tornar-avaliador'] = '/solicitacao/tornarAvaliador';
$routes['/api/solicitacao/telefone-cliente'] = '/solicitacao/telefoneCliente';
$routes['/api/solicitacao/email-cliente'] = '/solicitacao/emailCliente';
$routes['/api/solicitacao/aprovar'] = '/solicitacao/aprovar';
$routes['/api/solicitacao/reprovar'] = '/solicitacao/reprovar';
$routes['/logout'] = '/login/logout';