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

    $categoria_id = $_POST['categoria_id']; 
    $nome_produto = $_POST['nome_produto'];
    $imagem =  $rand.$nome_img;
    $valor = $_POST['valor'];
    $unidade_venda = $_POST['unidade_venda'];
    $descricao = $_POST['descricao'];
    $destaque = $_POST['destaque'];
   
    $update = "update produtos
                set id_categoria = $categoria_id,
                nome_produto = '$nome_produto',
                imagem = '$nome_img' 
                valor = $valor,
                unidade_venda = '$unidade_venda',
                descricao = '$descricao',
                destaque = '$destaque',
                where id = $id;";
    $resultado = $conn->query($update);
    if($resultado){
        header('location:lista_produtos.php');
    }
}
if($_GET){
    $id_form = $_GET['id'];
}else{
    $id_form = 0;
}
$lista = $conn->query('select * from produtos where id =' .$id_form);
$row = $lista->fetch_assoc();

// selecionar a lista de tipos para preencher o <select>
$listaTipo = $conn->query("select * from tipos order by rotulo");
$rowTipo = $listaTipo->fetch_assoc();
$numLinhas = $listaTipo->num_rows;

?>
<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="../css/bootstrap.min.css">
    <link rel="stylesheet" href="../css/estilo.css">
    <title>Produto - Insere</title>
</head>
<body>
<?php include "menu_adm.php";?>
<main class="container">
    <div class="row">
        <div class="col-xs-12 col-sm-offset-2 col-sm-6  col-md-8">
            <h2 class="breadcrumb text-danger">
                <a href="produtos_lista.php">
                    <button class="btn btn-danger">
                        <span class="glyphicon glyphicon-chevron-left"></span>
                    </button>
                </a>
                Inserindo Produtos
            </h2>
            <div class="thumbnail">
                <div class="alert alert-danger" role="alert">
                    <form action="produtos_atualiza.php" method="post" 
                    name="form_insere" enctype="multipart/form-data"
                    id="form_insere">
                         <!-- campo id deve permanecer oculto "hidden"  -->
                    <input type="hidden" name="id" id="id" value="<?php echo $row['id']; ?>">
                    
                    <label for="id_tipo">Tipo:</label>
                        <div class="input-group">
                            <span class="input-group-addon">
                                <span class="glyphicon glyphicon-tasks" aria-hidden="true"></span>
                            </span>
                            <select name="id_tipo" id="id_tipo" class="form-control" required>
                                <?php do{ ?>    
                                    <option value="<?php echo $rowTipo['id'] ?>" 
                                       <?php 
                                            if(!(strcmp($rowTipo['id'],$row['tipo_id']))){
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
                                
                                <?php  echo $row['destaque']=="Sim"?"checked":null; ?> >Sim
                            </label>
                            <label for="destaque_n" class="radio-inline">
                                <input type="radio" name="destaque" id="destaque" value="Não" 
                                <?php echo $row['destaque']=="Não"?"checked":null; ?> >Não
                            </label>
                        </div>
                            <label for="descricao">Descrição:</label>     
                        <div class="input-group">
                           <span class="input-group-addon">
                                <span class="glyphicon glyphicon-cutlery" aria-hidden="true"></span>
                           </span>
                           <input type="text" name="descricao" id="descricao" 
                                class="form-control" placeholder="Digite a descrição do Produto"
                                maxlength="100" value="<?php echo $row['descricao'];  ?>">
                        </div>   
                        
                        <label for="resumo">Resumo:</label>     
                        <div class="input-group">
                           <span class="input-group-addon">
                                <span class="glyphicon glyphicon-list-alt" aria-hidden="true"></span>
                           </span>
                           <textarea  name="resumo" id="resumo"
                                cols="30" rows="8"
                                class="form-control" placeholder="Digite os detalhes do Produto"
                                >
                                <?php echo $row['resumo']; ?>
                            </textarea>
                        </div> 
                        
                        <label for="valor">Valor:</label>     
                        <div class="input-group">
                           <span class="input-group-addon">
                                <span class="glyphicon glyphicon-tags" aria-hidden="true"></span>
                           </span>
                           <input type="number" name="valor" id="valor" 
                                class="form-control" required min="0" step="0.01" value="<?php echo $row['valor']; ?>">
                        </div>   

                        <label for="imagem_atual">Imagem Atual:</label> 
                        <img src="../images/<?php echo $row['imagem']; ?>" alt="" srcset="">
                        <input type="hidden" name="imagem_atual" id="imagem_atual" value="<?php echo $row['imagem']; ?>" >

                        <label for="imagem">Imagem Nova:</label>    
                        <div class="input-group">
                            <span class="input-group-addon">
                                <span class="glyphicon glyphicon-picture" aria-hidden="true"></span>
                           </span>
                           <img src="" name="imagem" id="imagem" class="img-responsive">
                           <input type="file" name="imagemfile" id="imagemfile" class="form-control" accept="image/*">
                        </div>

                        <br>
                        <input type="submit" name="atualizar" id="atualizar" class="btn btn-danger btn-block" value="Atualizar">
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