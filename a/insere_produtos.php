<?php 
include 'acesso_com.php';
include '../banco/connect.php';
if($_POST){
    if(isset($_POST['enviar'])){
        $nome_img = $_FILES['imagemfile']['name'];
        $tmp_img = $_FILES['imagemfile']['tmp_name'];
        $rand = rand(100001,999999);
        $dir_img = "../img/ADM".$rand.$nome_img;
        move_uploaded_file($tmp_img,$dir_img);
    }

    $id = $_POST['id_tipo'];
    $destaque = $_POST['destaque'];
    $descricao = $_POST['descricao'];
    $resumo = $_POST['resumo'];
    $valor = $_POST['valor'];
    $imagem =  $rand.$nome_img;
    
    $insereProduto = "insert produtos 
                    (tipo_id, descricao, resumo, valor, imagem, destaque)
                    values
                    ($id,'$descricao', '$resumo', $valor, '$imagem', '$destaque') 
                    ";
    $resultado = $conn->query($insereProduto);            
    if(mysqli_insert_id($conn)){
        header('lista_produto.php');
    }
}
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
    <title>SM Locações - Inserir Produtos</title>
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
                Inserindo Produtos
            </h2>
            <div class="thumbnail-insere">
                <div class="alert alert-success" role="alert">
                    <form action="produtos_insere.php" method="post" 
                    name="form_insere" enctype="multipart/form-data"
                    id="form_insere">
                        <label for="id_tipo">Tipo:</label>
                        <div class="input-group-text">
                            <span class="input">
                                <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-card-list" viewBox="0 0 16 16">
                                <path d="M14.5 3a.5.5 0 0 1 .5.5v9a.5.5 0 0 1-.5.5h-13a.5.5 0 0 1-.5-.5v-9a.5.5 0 0 1 .5-.5zm-13-1A1.5 1.5 0 0 0 0 3.5v9A1.5 1.5 0 0 0 1.5 14h13a1.5 1.5 0 0 0 1.5-1.5v-9A1.5 1.5 0 0 0 14.5 2z"/>
                                <path d="M5 8a.5.5 0 0 1 .5-.5h7a.5.5 0 0 1 0 1h-7A.5.5 0 0 1 5 8m0-2.5a.5.5 0 0 1 .5-.5h7a.5.5 0 0 1 0 1h-7a.5.5 0 0 1-.5-.5m0 5a.5.5 0 0 1 .5-.5h7a.5.5 0 0 1 0 1h-7a.5.5 0 0 1-.5-.5m-1-5a.5.5 0 1 1-1 0 .5.5 0 0 1 1 0M4 8a.5.5 0 1 1-1 0 .5.5 0 0 1 1 0m0 2.5a.5.5 0 1 1-1 0 .5.5 0 0 1 1 0"/>
                                </svg>
                            </span>
                            <select name="id_tipo" id="id_tipo" class="form-control" required>
                                <?php do{ ?>
                                    <option value="<?php echo $rowTipo['id']; ?>">
                                    <?php echo $rowTipo['categorias.rotulo']; ?>
                                    </option>
                                <?php }while($rowTipo = $listaTipo->fetch_assoc()); ?>
                            </select>
                        </div>
                        <label for="destaque">Destaque:</label>
                        <div class="input-group">
                            <label for="destaque_s" class="radio-inline">
                                <input type="radio" name="destaque" id="destaque" value="Sim">Sim
                            </label>
                            <label for="destaque_n" class="radio-inline">
                                <input type="radio" name="destaque" id="destaque" value="Não" checked>Não
                            </label>
                        </div>
                            <label for="nome">Nome do Produto:</label>     
                        <div class="input-group-text">
                           <span class="input-group-addon">
                                <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-card-text" viewBox="0 0 16 16">
                                <path d="M14.5 3a.5.5 0 0 1 .5.5v9a.5.5 0 0 1-.5.5h-13a.5.5 0 0 1-.5-.5v-9a.5.5 0 0 1 .5-.5zm-13-1A1.5 1.5 0 0 0 0 3.5v9A1.5 1.5 0 0 0 1.5 14h13a1.5 1.5 0 0 0 1.5-1.5v-9A1.5 1.5 0 0 0 14.5 2z"/>
                                <path d="M3 5.5a.5.5 0 0 1 .5-.5h9a.5.5 0 0 1 0 1h-9a.5.5 0 0 1-.5-.5M3 8a.5.5 0 0 1 .5-.5h9a.5.5 0 0 1 0 1h-9A.5.5 0 0 1 3 8m0 2.5a.5.5 0 0 1 .5-.5h6a.5.5 0 0 1 0 1h-6a.5.5 0 0 1-.5-.5"/>
                                </svg>                           
                            </span>
                           <input type="text" name="nome" id="nome" 
                                class="form-control" placeholder="Digite o Nome do Produto"
                                maxlength="100" required>
                        </div>   
                        
                        <label for="descricao">Descrição:</label>     
                        <div class="input-group-text">
                           <span class="input-group-addon">
                                <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-card-heading" viewBox="0 0 16 16">
                                <path d="M14.5 3a.5.5 0 0 1 .5.5v9a.5.5 0 0 1-.5.5h-13a.5.5 0 0 1-.5-.5v-9a.5.5 0 0 1 .5-.5zm-13-1A1.5 1.5 0 0 0 0 3.5v9A1.5 1.5 0 0 0 1.5 14h13a1.5 1.5 0 0 0 1.5-1.5v-9A1.5 1.5 0 0 0 14.5 2z"/>
                                <path d="M3 8.5a.5.5 0 0 1 .5-.5h9a.5.5 0 0 1 0 1h-9a.5.5 0 0 1-.5-.5m0 2a.5.5 0 0 1 .5-.5h6a.5.5 0 0 1 0 1h-6a.5.5 0 0 1-.5-.5m0-5a.5.5 0 0 1 .5-.5h9a.5.5 0 0 1 .5.5v1a.5.5 0 0 1-.5.5h-9a.5.5 0 0 1-.5-.5z"/>
                                </svg>
                           </span>
                           <textarea  name="descricao" id="descricao"
                                cols="30" rows="8"
                                class="form-control" placeholder="Digite os detalhes do Produto"
                                required></textarea>
                        </div> 
                        
                        <label for="valor">Valor:</label>     
                        <div class="input-group mb-3">
                            <span class="input-group-text">R$</span>
                            <span class="input-group-text">0.00</span>
                            <input type="text" class="form-control" aria-label="Dollar amount (with dot and two decimal places)">
                        </div>  
                        <label for="imagem">Imagem:</label>    
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
                        <input type="submit" name="enviar" id="enviar" class="btn btn-success btn-block" value="Cadastrar">
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