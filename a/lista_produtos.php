<!-- CONECTAR NO BANCO E SELECIONAR AS INFORMAÇÕES -->
<?php
include 'acesso_com.php';
include '../banco/connect.php';

$lista = $conn -> query("select * from vw_produtos");
$row = $lista -> fetch_assoc();
$rows = $lista -> num_rows;
?>

<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Produtos - Lista</title>
    <link rel="stylesheet" href="../css/bootstrap.css">
    <link rel="stylesheet" href="../css/estilo.css">
</head>
<body class="corpo_lista"> 
    <?php include 'menu_adm_op.php'; ?>

    <main class="container-lista">
        <h2 class="breadcrumb-lista alert alert-success">Lista de Produtos</h2>

        <table class="table-lista table-hover-lista table-condensed-lista tb-opacidade-lista bg-warning-lista">
            <thead>
                <tr>
                    <th class="d-none">ID</th>
                    <th>TIPO</th>
                    <th>DESCRIÇÃO</th>
                    <th>RESUMO</th>
                    <th>VALOR</th>
                    <th>IMAGEM</th>
                    <th>
                        <a href="insere_produtos.php" class="btn btn-primary btn-xs">
                            <span class="add">
                                <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-plus" viewBox="0 0 16 16">
                                <path d="M8 4a.5.5 0 0 1 .5.5v3h3a.5.5 0 0 1 0 1h-3v3a.5.5 0 0 1-1 0v-3h-3a.5.5 0 0 1 0-1h3v-3A.5.5 0 0 1 8 4"/>
                            </svg>
                            </span> <span class="hidden-xs">ADICIONAR</span>
                        </a>
                    </th>
                </tr>
            </thead>
            <tbody>
                <?php do { ?>
                    <tr>
                        <td class="d-none"><?php echo $row['produto_id']; ?></td>
                        <td><?php echo $row['rotulo']; ?></td>
                        <td>
                            <?php
                                if($row['destaque'] == 'Sim') {
                                    echo '<i class="bi bi-star-fill" aria-hidden="true"></i>';
                                } else {
                                    echo '<i class="bi bi-brightness-alt-high-fill" aria-hidden="true"></i>';
                                }
                                echo '&nbsp;' . $row['nome_produto'];
                            ?>
                        </td>
                        <td><?php echo $row['descricao']; ?></td>
                        <td><?php echo number_format($row['valor'], 2, ',', '.'); ?></td>
                        <td>
                            <img src="../img/produtos/<?php echo $row['imagem']; ?>" width="100px" alt="Imagem do produto">
                        </td>
                        <td>
                            <a
                                href="update_produtos.php?id=<?php echo $row['produto_id'] ?>" 
                                role="button" 
                                class="btn btn-warning btn-block btn-xs"
                            >
                                <span>
                                    <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-arrow-clockwise" viewBox="0 0 16 16">
                                        <path fill-rule="evenodd" d="M8 3a5 5 0 1 0 4.546 2.914.5.5 0 0 1 .908-.417A6 6 0 1 1 8 2z"/>
                                        <path d="M8 4.466V.534a.25.25 0 0 1 .41-.192l2.36 1.966c.12.1.12.284 0 .384L8.41 4.658A.25.25 0 0 1 8 4.466"/>
                                    </svg>
                                </span>
                                <span class="hidden-xs">ALTERAR</span>    
                            </a>
                            <!-- Botão excluir -->
                            <!-- não mostrar o botão excluir se o produto estiver em destaque -->
                                <?php  
                                    $regraExcluir = $conn->query("select destaque from vw_produtos where produto_id =".$row['produto_id']);
                                    $regraRow = $regraExcluir->fetch_assoc();
                                ?>

                            <button 
                                data-nome="<?php echo $row['nome_produto']; ?>"
                                data-id="<?php echo $row['produto_id']; ?>"
                                class="delete btn btn-xs btn-block btn-danger
                                <?php echo $regraRow['destaque']=='Sim'?'hidden':'' ?>
                                "     
                            >
                                <span>
                                <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-trash" viewBox="0 0 16 16">
                                    <path d="M5.5 5.5A.5.5 0 0 1 6 6v6a.5.5 0 0 1-1 0V6a.5.5 0 0 1 .5-.5m2.5 0a.5.5 0 0 1 .5.5v6a.5.5 0 0 1-1 0V6a.5.5 0 0 1 .5-.5m3 .5a.5.5 0 0 0-1 0v6a.5.5 0 0 0 1 0z"/>
                                    <path d="M14.5 3a1 1 0 0 1-1 1H13v9a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2V4h-.5a1 1 0 0 1-1-1V2a1 1 0 0 1 1-1H6a1 1 0 0 1 1-1h2a1 1 0 0 1 1 1h3.5a1 1 0 0 1 1 1zM4.118 4 4 4.059V13a1 1 0 0 0 1 1h6a1 1 0 0 0 1-1V4.059L11.882 4zM2.5 3h11V2h-11z"/>
                                    </svg>    
                                </span>
                                </span>
                                <span class="hidden-xs">EXCLUIR</span>
                        </td>
                    </tr>
                <?php } while ($row = $lista->fetch_assoc()); ?>
            </tbody>
        </table>
    </main>

    <!-- Modal de confirmação de exclusão -->
    <div class="modal fade" id="modalEdit" role="dialog">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h4>Vamos deletar?</h4>
                    <button class="close" data-dismiss="modal" type="button">&times;</button>
                </div>
                <div class="modal-body">
                    Deseja mesmo excluir o item?
                    <h4><span class="nome text-danger"></span></h4>
                </div>
                <div class="modal-footer">
                    <a href="#" class="btn btn-danger delete-yes">Confirmar</a>
                    <button class="btn btn-success" data-dismiss="modal">Cancelar</button>
                </div>
            </div>
        </div>
    </div>

    <!-- Scripts -->
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/1.12.4/jquery.min.js"></script>
    <script src="../js/bootstrap.min.js"></script>
    <script type="text/javascript">
        $('.delete').on('click', function() {
            var nome = $(this).data('nome'); // busca o nome do produto
            var id = $(this).data('id'); // busca o id do produto
            $('span.nome').text(nome); // insere o nome no modal
            $('a.delete-yes').attr('href', 'produtos_excluir.php?id=' + id); // define o link de exclusão
            $('#modalEdit').modal('show'); // exibe o modal
        });
    </script>
</body>
</html>
