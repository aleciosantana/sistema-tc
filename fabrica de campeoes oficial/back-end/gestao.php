<?php
$servername = "localhost";
$username = "root";
$password = "";
$dbname = "fabricadecampeoes";
$port = '3306';

$conn = new mysqli($servername, $username, $password, $dbname, $port);
if ($conn->connect_error) {
    die("Erro na conexão: " . $conn->connect_error);
}

//Dashboard data

//Resgata pedidos cadastrados
$result = $conn->query("SELECT COUNT(*) as total FROM pedido");
$totalPedidos = $result->fetch_assoc();

//Resgata qtd clientes cadastrados
$result = $conn->query("SELECT COUNT(*) as total FROM cliente");
$totalClientes = $result->fetch_assoc();

// Resgata valor total
$result = $conn->query("SELECT SUM(vlCompra) as total FROM pedido");
$faturamentoTotal = $result->fetch_assoc();

//Resgata qtd produtos cadastrados
$result = $conn->query("SELECT SUM(quantidade) as total FROM produto");
$produtosEmEstoque = $result->fetch_assoc();

// Resgata media de avaliacoes
$result = $conn->query("SELECT FORMAT(AVG(avaliaCompra), 1) AS media FROM pedido");
$mediaAvaliacao = $result->fetch_assoc();

//ultimos pedidos
$result = $conn->query("SELECT 
  p.protCompra,
  c.nome AS nomeCliente,
  t.numero AS telefone,
  p.dtPedido AS dataPedido,
  pr.nome AS nomeProduto,
  pr.descricao AS descricaoProduto
FROM 
  pedido as p
  INNER JOIN cliente as c ON p.idCliente = c.idCliente
  INNER JOIN telefone as t ON c.idCliente = t.idCliente
  INNER JOIN produto as pr ON p.idEstoque = pr.idProduto
  ORDER BY p.dtPedido DESC
  LIMIT 5 ");
$ultimosPedidos = $result->fetch_all(MYSQLI_ASSOC);

//data dashboard
//ultimos pedidos
$result = $conn->query("SELECT 
  DATE(p.dtPedido) AS dataPedido,
  SUM(p.quantidade) AS totalVendas
FROM 
  pedido as p
  INNER JOIN cliente as c ON p.idCliente = c.idCliente
  INNER JOIN telefone as t ON c.idCliente = t.idCliente
  INNER JOIN produto as pr ON p.idEstoque = pr.idProduto
GROUP BY 
  DATE(p.dtPedido)
ORDER BY 
  dataPedido");
$consultaGeral = $result->fetch_all(MYSQLI_ASSOC);

//Encerra conexão
$conn->close();

echo json_encode(array(
    'totalPedidos' => $totalPedidos['total'],
    'totalClientes' => $totalClientes['total'],
    'faturamentoTotal' => $faturamentoTotal['total'],
    'produtosEmEstoque' => $produtosEmEstoque['total'],
    'mediaAvaliacao' => $mediaAvaliacao['media'],
    'ultimosPedidos' => $ultimosPedidos,
    'consultaGeral' => $consultaGeral
));

