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
        <h2 class="breadcrumb-lista alert-danger">Lista de Produtos</h2>

        <table class="table-lista table-hover-lista table-condensed-lista tb-opacidade-lista bg-warning-lista">
            <thead>
                <tr>
                    <th class="hidden">ID</th>
                    <th>TIPO</th>
                    <th>DESCRIÇÃO</th>
                    <th>RESUMO</th>
                    <th>VALOR</th>
                    <th>IMAGEM</th>
                    <th>
                        <a href="produtos_insere.php" class="btn btn-primary btn-xs">
                            <span class="   "></span> <span class="hidden-xs">ADICIONAR</span>
                        </a>
                    </th>
                </tr>
            </thead>
            <tbody>
                <?php do { ?>
                    <tr>
                        <td class="hidden"><?php echo $row['id']; ?></td>
                        <td><?php echo $row['rotulo']; ?></td>
                        <td>
                            <?php
                                if($row['destaque'] == 'Sim') {
                                    echo '<span class="glyphicon glyphicon-star text-danger" aria-hidden="true"></span>';
                                } else {
                                    echo '<span class="glyphicon glyphicon-ok text-success" aria-hidden="true"></span>';
                                }
                                echo '&nbsp;' . $row['descricao'];
                            ?>
                        </td>
                        <td><?php echo $row['resumo']; ?></td>
                        <td><?php echo number_format($row['valor'], 2, ',', '.'); ?></td>
                        <td>
                            <img src="../images/<?php echo $row['imagem']; ?>" width="100px" alt="Imagem do produto">
                        </td>
                        <td>
                            <a href="produtos_atualiza.php?id=<?php echo $row['id']; ?>" class="btn btn-warning btn-xs">
                                <span class="glyphicon glyphicon-refresh"></span> <span class="hidden-xs">ALTERAR</span>
                            </a>
                            <!-- Botão excluir -->
                            <?php
                                $regra = $conn->query("SELECT destaque FROM vw_produtos WHERE id = ".$row['id']);
                                $regraRow = $regra->fetch_assoc();
                            ?>
                            <button 
                                data-nome="<?php echo $row['descricao']; ?>"
                                data-id="<?php echo $row['id']; ?>"
                                class="delete btn btn-danger btn-xs <?php echo $regraRow['destaque'] == 'Sim' ? 'hidden' : ''; ?>"
                            >
                                <span class="glyphicon glyphicon-trash"></span> <span class="hidden-xs">EXCLUIR</span>
                            </button>
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
