<?php 
include 'acesso_com.php';
include '../banco/connect.php';
if($_POST){ // se o usuário clicou no botão atualizar
    if ($_FILES['imagemfile']['name']) {// se o usuario escolher uma imagem
        unlink("../img/produtos/".$_POST['imagem_atual']); // apaga a imagem atual do servidor de arquivos
        $nome_img = $_FILES['imagemfile']['name']; 
        $tmp_img = $_FILES['imagemfile']['tmp_name'];
        $rand = rand(100001,999999); // gera um número aleatório pra imagem
        $dir_img = "../img/produtos/".$rand.$nome_img;
        move_uploaded_file($tmp_img,$dir_img); // transfere a imagem para a pasta 
        $nome_img = $rand.$nome_img;
    }else{
        $nome_img = $_POST['imagem_atual'];
    }

    $id = $_POST['id'];
    $categoria_id = $_POST['categoria_id']; 
    $nome_produto = $_POST['nome_produto'];
    $imagem =  $nome_img;
    $valor = $_POST['valor'];
    $unidade_venda = $_POST['unidade_venda'];
    $descricao = $_POST['descricao'];
    $destaque = $_POST['destaque'];
   
    $update = "update produtos
                set id_categoria = $categoria_id,
                nome_produto = '$nome_produto',
                imagem = '$nome_img',
                valor = $valor,
                unidade_venda = '$unidade_venda',
                descricao = '$descricao',
                destaque = '$destaque'
                where id = $id;";
    $resultado = $conn->query($update);
    if($resultado){
        header('location:lista_produtos.php');
    }
}
if(isset($_GET)){
    $id_form = $_GET['id'];
}else{
    $id_form = 0;
}
$lista = $conn->query('select * from produtos where id =' .$id_form);
$row = $lista->fetch_assoc();

// selecionar a lista de tipos para preencher o <select>
$listaTipo = $conn->query("select * from categorias order by rotulo");
$rowTipo = $listaTipo->fetch_assoc();
$numLinhas = $listaTipo->num_rows;

?>
<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="../css/bootstrap.css">
    <link rel="stylesheet" href="../css/estilo.css">
    <title>SM Locações Produtos</title>
</head>
<body>
<?php include "menu_adm_op.php";?>
<main class="container-inserir mx-auto">
    <div class="mx-auto">
        <div class="col-xs-12 col-sm-offset-2 col-sm-6  col-md-8 mx-auto">
            <h2 class="breadcrumb-insere alert text-success">
                <a href="lista_produtos.php">
                    <button class="btn btn-success">
                        <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-arrow-return-left" viewBox="0 0 16 16">
                        <path fill-rule="evenodd" d="M14.5 1.5a.5.5 0 0 1 .5.5v4.8a2.5 2.5 0 0 1-2.5 2.5H2.707l3.347 3.346a.5.5 0 0 1-.708.708l-4.2-4.2a.5.5 0 0 1 0-.708l4-4a.5.5 0 1 1 .708.708L2.707 8.3H12.5A1.5 1.5 0 0 0 14 6.8V2a.5.5 0 0 1 .5-.5"/>
                        </svg>
                    </button>
                </a>
                Atualizar Produtos
            </h2>
            <div class="thumbnail-insere">
                <div class="alert alert-success" role="alert">
                    <form action="update_produtos.php" method="post" 
                    name="form_insere" enctype="multipart/form-data"
                    id="form_insere">
                    <input type="hidden" name="id" value="<?php echo $row['id']; ?>">
                        <label for="categoria_id">Tipo:</label>
                        <div class="input-group-text">
                            <span class="input-group-addon">
                                <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-card-list" viewBox="0 0 16 16">
                                <path d="M14.5 3a.5.5 0 0 1 .5.5v9a.5.5 0 0 1-.5.5h-13a.5.5 0 0 1-.5-.5v-9a.5.5 0 0 1 .5-.5zm-13-1A1.5 1.5 0 0 0 0 3.5v9A1.5 1.5 0 0 0 1.5 14h13a1.5 1.5 0 0 0 1.5-1.5v-9A1.5 1.5 0 0 0 14.5 2z"/>
                                <path d="M5 8a.5.5 0 0 1 .5-.5h7a.5.5 0 0 1 0 1h-7A.5.5 0 0 1 5 8m0-2.5a.5.5 0 0 1 .5-.5h7a.5.5 0 0 1 0 1h-7a.5.5 0 0 1-.5-.5m0 5a.5.5 0 0 1 .5-.5h7a.5.5 0 0 1 0 1h-7a.5.5 0 0 1-.5-.5m-1-5a.5.5 0 1 1-1 0 .5.5 0 0 1 1 0M4 8a.5.5 0 1 1-1 0 .5.5 0 0 1 1 0m0 2.5a.5.5 0 1 1-1 0 .5.5 0 0 1 1 0"/>
                                </svg>
                            </span>
                            <select name="categoria_id" id="categoria_id" class="form-control" required>
                            <?php do{ ?>    
                                    <option value="<?php echo $rowTipo['id'] ?>" 
                                       <?php 
                                            if(!(strcmp($rowTipo['id'],$row['id_categoria']))){
                                                echo "selected=\"selected\"";
                                            }
                                       ?> 
                                    >      
                                        <?php echo $rowTipo['rotulo'] ?>
                                    </option>
                                <?php }while($rowTipo = $listaTipo->fetch_assoc()); ?> 
                            </select>
                        </div>
                        <label for="destaque">Destaque:</label>
                        <div class="input-group">
                            <label for="destaque_s" class="radio-inline">
                                <input type="radio" name="destaque" id="destaque" value="Sim"
                                <?php echo $row['destaque']=="Sim"?"checked":null; ?> >Sim
                            </label>
                            <label for="destaque_n" class="radio-inline">
                                <input type="radio" name="destaque" id="destaque" value="Nao"
                                <?php echo $row['destaque']=="Nao"?"checked":null; ?> >Não
                            </label>
                        </div>
                            <label for="nome_produto">Nome do Produto:</label>     
                        <div class="input-group-text">
                           <span class="input-group-addon">
                                <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-card-text" viewBox="0 0 16 16">
                                <path d="M14.5 3a.5.5 0 0 1 .5.5v9a.5.5 0 0 1-.5.5h-13a.5.5 0 0 1-.5-.5v-9a.5.5 0 0 1 .5-.5zm-13-1A1.5 1.5 0 0 0 0 3.5v9A1.5 1.5 0 0 0 1.5 14h13a1.5 1.5 0 0 0 1.5-1.5v-9A1.5 1.5 0 0 0 14.5 2z"/>
                                <path d="M3 5.5a.5.5 0 0 1 .5-.5h9a.5.5 0 0 1 0 1h-9a.5.5 0 0 1-.5-.5M3 8a.5.5 0 0 1 .5-.5h9a.5.5 0 0 1 0 1h-9A.5.5 0 0 1 3 8m0 2.5a.5.5 0 0 1 .5-.5h6a.5.5 0 0 1 0 1h-6a.5.5 0 0 1-.5-.5"/>
                                </svg>                           
                            </span>
                           <input type="text" name="nome_produto" id="nome_produto" 
                                class="form-control" placeholder="Digite o Nome do Produto"
                                maxlength="100" value="<?php echo $row['nome_produto'];  ?>">
                        </div>   
                        
                        <label for="descricao">Descrição:</label>     
                        <div class="input-group-text">
                        <span class="input-group-addon">
                                <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-card-heading" viewBox="0 0 16 16">
                                <path d="M14.5 3a.5.5 0 0 1 .5.5v9a.5.5 0 0 1-.5.5h-13a.5.5 0 0 1-.5-.5v-9a.5.5 0 0 1 .5-.5zm-13-1A1.5 1.5 0 0 0 0 3.5v9A1.5 1.5 0 0 0 1.5 14h13a1.5 1.5 0 0 0 1.5-1.5v-9A1.5 1.5 0 0 0 14.5 2z"/>
                                <path d="M3 8.5a.5.5 0 0 1 .5-.5h9a.5.5 0 0 1 0 1h-9a.5.5 0 0 1-.5-.5m0 2a.5.5 0 0 1 .5-.5h6a.5.5 0 0 1 0 1h-6a.5.5 0 0 1-.5-.5m0-5a.5.5 0 0 1 .5-.5h9a.5.5 0 0 1 .5.5v1a.5.5 0 0 1-.5.5h-9a.5.5 0 0 1-.5-.5z"/>
                                </svg>
                        </span>
                        <textarea name="descricao" id="descricao" cols="30" rows="8" class="form-control" placeholder="Digite os detalhes do Produto"><?php echo htmlspecialchars(trim($row['descricao'])); ?></textarea>
                        </div>

                        
                        <label for="valor">Valor:</label>     
                        <div class="input-group mb-3">
                            <span class="input-group-text">R$</span>
                            <input type="number" name="valor" id="valor" 
                                class="form-control" required min="0" step="0.01" value="<?php echo $row['valor']; ?>">
                        </div>   

                        <label for="unidade_venda">Unidade de Venda:</label>     
                        <div class="input-group-text mb-3">
                            <span class="input-group-text">
                                <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-123" viewBox="0 0 16 16">
                                    <path d="M2.873 11.297V4.142H1.699L0 5.379v1.137l1.64-1.18h.06v5.961zm3.213-5.09v-.063c0-.618.44-1.169 1.196-1.169.676 0 1.174.44 1.174 1.106 0 .624-.42 1.101-.807 1.526L4.99 10.553v.744h4.78v-.99H6.643v-.069L8.41 8.252c.65-.724 1.237-1.332 1.237-2.27C9.646 4.849 8.723 4 7.308 4c-1.573 0-2.36 1.064-2.36 2.15v.057zm6.559 1.883h.786c.823 0 1.374.481 1.379 1.179.01.707-.55 1.216-1.421 1.21-.77-.005-1.326-.419-1.379-.953h-1.095c.042 1.053.938 1.918 2.464 1.918 1.478 0 2.642-.839 2.62-2.144-.02-1.143-.922-1.651-1.551-1.714v-.063c.535-.09 1.347-.66 1.326-1.678-.026-1.053-.933-1.855-2.359-1.845-1.5.005-2.317.88-2.348 1.898h1.116c.032-.498.498-.944 1.206-.944.703 0 1.206.435 1.206 1.07.005.64-.504 1.106-1.2 1.106h-.75z"/>
                                </svg>
                            </span>
                            <input type="number" class="form-control" id="unidade_venda" name="unidade_venda" aria-label="Quantidade de unidade de venda" placeholder="0" min="1" step="1" value="<?php echo $row['unidade_venda']; ?>">
                        </div>

                        <label for="imagem_atual">Imagem Atual:</label> 
                        <img src="../img/produtos/<?php echo $row['imagem']; ?>" alt="" width="150" height="150">
                        <input type="hidden" name="imagem_atual" id="imagem_atual" value="<?php echo $row['imagem']; ?>" >
                        <br>

                        <label for="imagem">Imagem Nova:</label>    
                        <div class="input-group-text">
                            <span class="input-group-addon">
                                <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-card-image" viewBox="0 0 16 16">
                                <path d="M6.002 5.5a1.5 1.5 0 1 1-3 0 1.5 1.5 0 0 1 3 0"/>
                                <path d="M1.5 2A1.5 1.5 0 0 0 0 3.5v9A1.5 1.5 0 0 0 1.5 14h13a1.5 1.5 0 0 0 1.5-1.5v-9A1.5 1.5 0 0 0 14.5 2zm13 1a.5.5 0 0 1 .5.5v6l-3.775-1.947a.5.5 0 0 0-.577.093l-3.71 3.71-2.66-1.772a.5.5 0 0 0-.63.062L1.002 12v.54L1 12.5v-9a.5.5 0 0 1 .5-.5z"/>
                                </svg>
                            </span>
                           <img src="" name="imagem" id="imagem" class="img-responsive">
                           <input type="file" name="imagemfile" id="imagemfile" class="form-control" accept="image/*">
                        </div>

                        <br>
                        <input type="submit" name="atualizar" id="atualizar" class="btn btn-success  btn-block" value="Atualizar">                    
                    </form>
                </div>
            </div>
        </div>
    </div>
</main>

<!-- Script para imagem -->
<script>
document.getElementById("imagem").onchange = function(){
    var reader = new FileReader();
    if(this.files[0].size>512000){
        alert("A imagem deve ter no máximo 500KB");
        $("#imagem").attr("src", "blank");
        $("#imagem").hide();
        $("#imagem").wrap('<form>').closest('form').get(0).reset();
        $("#imagem").unwrap();
        return false
    }
    if(this.files[0].type.indexOf("image")==-1){
        alert("formato inválido, escolha uma imagem!");
        $("#imagem").attr("src", "blank");
        $("#imagem").hide();
        $("#imagem").wrap('<form>').closest('form').get(0).reset();
        $("#imagem").unwrap();
        return false
    }
    reader.onload = function(e){
        document.getElementById("imagem").src = e.target.result
        $("#imagem").show();
    }
    reader.readAsDataURL(this.files[0])
}    
</script>

</body>
</html>