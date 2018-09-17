<template>
    <nav id="navigation" class="navbar-expand-md">
        <div class="container">
            <div class="row">
                <div class="col-md-4">
                    <div class="collapse navbar-collapse" id="main-nav">
                        <ul class="navbar-nav">
                            <li class="nav-item active">
                                <a class="nav-link" href="#">Explorar</a>
                            </li>
                            <li class="nav-item">
                                <a class="nav-link" href="#">Features</a>
                            </li>
                        </ul>
                    </div>
                </div>
            
                <div class="col-md-2 logo-spot">
                    <a class="navbar-brand" href="#">
                        <img src="/images/logo-header.png">
                    </a>
                    <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#main-nav">
                        <span class="navbar-toggler-icon"></span>
                    </button>
                </div>
                
                <div class="col-md-6 form-block">
                    <form class="form-inline">
                      <input class="form-control mr-1" type="text" placeholder="E-mail">
                      <input class="form-control" type="password" placeholder="Senha">
                      <button class="btn btn-primary" type="submit">Login</button>
                    </form>
                </div>
          </div>
        </div>
    </nav>
</template>

<script>
    export default {
        
    }
</script>