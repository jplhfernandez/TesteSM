
?>

<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="DESGRAca.css">
    <title>Produto - Insere</title>
</head>
<body>
<?php include "menu_adm_op.php";?>
<main class="container-insere">
    <div class="row">
        <div class="col-xs-12 col-sm-offset-2 col-sm-6  col-md-8">
            <h2 class="breadcrumb-insere alert text-success">
                <a href="lista_produtos.php">
                    <button class="btn btn-success">
                        <span class="glyphicon glyphicon-chevron-left"></span>
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
                        <div class="input-group">
                            <span class="input-group-addon">
                                <span class="glyphicon glyphicon-tasks" aria-hidden="true"></span>
                            </span>
                            <select name="id_tipo" id="id_tipo" class="form-control" required>
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
                            <label for="descricao">Descrição:</label>     
                        <div class="input-group">
                           <span class="input-group-addon">
                                <span class="glyphicon glyphicon-cutlery" aria-hidden="true"></span>
                           </span>
                           <input type="text" name="descricao" id="descricao" 
                                class="form-control" placeholder="Digite a descrição do Produto"
                                maxlength="100" required>
                        </div>   
                        
                        <label for="resumo">Resumo:</label>     
                        <div class="input-group">
                           <span class="input-group-addon">
                                <span class="glyphicon glyphicon-list-alt" aria-hidden="true"></span>
                           </span>
                           <textarea  name="resumo" id="resumo"
                                cols="30" rows="8"
                                class="form-control" placeholder="Digite os detalhes do Produto"
                                required></textarea>
                        </div> 
                        
                        <label for="valor">Valor:</label>     
                        <div class="input-group">
                           <span class="input-group-addon">
                                <span class="glyphicon glyphicon-tags" aria-hidden="true"></span>
                           </span>
                           <input type="number" name="valor" id="valor" 
                                class="form-control" required min="0" step="0.01">
                        </div>   
                        <label for="imagem">Imagem:</label>    
                        <div class="input-group">
                            <span class="input-group-addon">
                                <span class="glyphicon glyphicon-picture" aria-hidden="true"></span>
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