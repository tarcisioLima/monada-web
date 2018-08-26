<template id="homepage">
    <div class="homepage">
       <header class="main-header">
           <nav id="navigation" class="navbar navbar-expand-lg">
              <a class="navbar-brand" href="#"><img src="/images/logo.png"></a>
              <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#main-nav">
                <span class="navbar-toggler-icon"></span>
              </button>
              <div class="collapse navbar-collapse" id="main-nav">
                <ul class="navbar-nav">
                  <li class="nav-item"><a class="nav-link" href="#">Sobre a rede</a></li>
                  <li class="nav-item"><a class="nav-link" href="#">Baixe o App</a></li>
                  <li class="nav-item"><a class="nav-link" href="#">Publicações</a></li>
                  <li class="nav-item"><a class="nav-link" href="#">Participar</a></li>
                </ul>
              </div>
            </nav>
           
           <div class="container">
               <h1>Monada Web</h1>
               <p>A rede que admira e preza pelos conteúdos intelectuais de forma <br>indivisível e indissolúvel </p>
               
             
                   <ul class="workflow-list">
                       <li>
                           <div class="icon"><i class="fa fa-lightbulb-o" aria-hidden="true"></i></div>
                           <p><span>Pense</span></p>
                       </li>
                       <li>
                           <div class="icon"><i class="fa fa-pencil" aria-hidden="true"></i></div>
                           <p><span>Escreva</span></p>
                       </li>
                       <li>
                           <div class="icon"><i class="fa fa-share-alt" aria-hidden="true"></i></div>
                           <p><span>Compartilhe</span></p>
                       </li>
                   </ul>

               
            </div>
       </header>
       <br><br> <br><br> <br><br> <br><br> <br><br> <br><br> <br><br> <br><br> <br><br> <br><br>
    </div>
</template>

<script>
    export default {
        mounted() {
            console.log('Homepage navigation is loaded');
        }
    }
</script>
