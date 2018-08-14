<template id="post">
    <div class="pd-10">
        <h3>{{ composition.title }}</h3>
        <strong>Conteúdo</strong><br>
        <div>
            {{ composition.body }}
        </div><br>
        <router-link :to="'/'" class="btn btn-primary"> Voltar para listagem</router-link>
        
    </div>
</template>

<script>
import mixin from '../mixins';
export default {
    mixins: [mixin],
    data () {
        return {
            composition: {
                title: '', body: ''
            }
        }
    },
    created () {       //O MALUCO É BRABO!!!
        let uri = this.basepath + '/compositions/' + this.$route.params.id
        Axios.get(uri).then((response) => {
            this.composition =  response.data.data;
        }).catch((e) => {
            console.log(e, 'deu ruim ao obter dados');
        });        
    }
}
</script>
