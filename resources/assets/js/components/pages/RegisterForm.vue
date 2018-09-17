<template>
    <div class="form-box">
        <div v-if="loader" class="loader-wrap"><div class="loader"></div></div>
        <div v-if="response.active" class="alert alert-success">
            <button type="button" class="close">
                <span aria-hidden="true">&times;</span>
            </button>
            Cadastro realizado com sucesso, já pode se logar na plataforma.
        </div>
        <form v-on:submit.prevent = "registerUser">
            <div class="form-group">
                <label for="name">Nome</label>
                <input type="text" id="name" v-model="register.name" :class="'form-control ' + hasError('name')" required>
                <div class="invalid-feedback" v-if="response.errors.name">
                    {{ response.errors.name[0] }}
                </div>
            </div>
            <div class="form-group">
                <label for="email">E-mail</label>
                <input type="email" id="email" v-model="register.email" :class="'form-control ' + hasError('email')" required>
                <div class="invalid-feedback" v-if="response.errors.email">
                    {{ response.errors.email[0] }}
              </div>
            </div>
            <div class="form-group">
                <label for="username">Nome de usuário</label>
                <input type="text" id="username" v-model="register.username" :class="'form-control ' + hasError('username')" required>
                <div class="invalid-feedback" v-if="response.errors.username">
                    {{ response.errors.username[0] }}
              </div>
            </div>
            <div class="row">
                <div class="col-md-6">
                    <div class="form-group">
                        <label for="pwd">Senha</label>
                        <input type="password" id="pwd" v-model="register.password" :class="'form-control ' + hasError('password')" required>
                        <div class="invalid-feedback" v-if="response.errors.password">
                            {{ response.errors.password[0] }}
                        </div>
                    </div>
                </div>
                <div class="col-md-6">
                    <div class="form-group">
                        <label for="pwdc">Confirme a senha</label>
                        <input type="password" id="pwdc" v-model="register.pwdc" :class="'form-control ' + hasError('pwdc')" required>
                        <div class="invalid-feedback" v-if="response.errors.pwdc">
                            {{ response.errors.pwdc[0] }}
                      </div>
                    </div>
                </div>
            </div>
            <div class="form-group">
                <div class="form-check-inline">
                  <label class="form-check-label">
                    <input type="checkbox" v-model="register.hasToken" class="form-check-input">Possuo código 
                  </label>
                </div>
                <div class="form-check-inline">
                  <label class="form-check-label">
                    <input type="checkbox" :class="'form-check-input ' + hasError('term')" v-model="register.term">Aceito o termos de uso.
                    <div class="invalid-feedback" v-if="response.errors.term">
                        {{ response.errors.term[0] }}
                    </div>
                  </label>
                </div>
            </div>
            <div class="form-group" v-if="register.hasToken">
                <input type="text" id="invite" placeholder="Insira o código de convite" v-model="register.invite" class="form-control" required>
            </div>
            <input type="submit" value="registrar"> 
        </form>      
    </div>
</template>

<script>

import mixin from '../../mixins';
export default {
    mixins: [mixin],
    data () {
        return {
           loader: false,
           register: {
               name: '',
               username: '',
               email: '',
               password: '',
               pwdc: '',
               term: false,
               hasToken: false,
               invite: ''
           },
           response: {
               active: false,
               errors: {}
           }
        }
    },
    methods: {
        registerUser (event) {
            if(this.register.password != this.register.pwdc) {
                this.response.errors = {"pwdc": ["As senhas divergem"]};
            }
            else {
                let uri = this.basepath + '/auth/register';
                this.loader = true;
                Axios.post(uri, this.register).then((data) => {
                    this.loader = false;
                    this.response.active = true;
                    this.response.errors = {};
                    event.target.reset();
                    console.log('sucesso: ', data)
                }).catch((e) => {
                    this.loader = false;
                    console.log('erro: ', e.response.data)
                    this.response.errors = e.response.data;
                });
            }
        },
        hasError(field) {
            return this.response.errors.hasOwnProperty(field) ? 'is-invalid' : '';
        }
    }
    
}
</script>