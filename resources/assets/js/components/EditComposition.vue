<template id="update-composition">
    <div>
        <h3>Atualize sua composição</h3>
        <form @submit.prevent = "updateComposition">
            <div class="form-group">
                <label for="edit-title">Titulo</label>
                <input type="text" id="edit-title" v-model="composition.title" class="form-control" required>
            </div>
            <div class="form-group">
                <label for="edit-body">Conteúdo</label>
                <textarea rows="10" id="edit-body" v-model="composition.body" class="form-control" required></textarea>
            </div>
            <button type="submit" class="btn btn-xs btn-primary">Atualizar</button>
            <router-link class="btn btn-xs btn-warning" :to="'/'">Voltar</router-link>
        </form>        
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
    created (){     
        let uri = this.basepath + '/compositions/' + this.$route.params.id + '/edit'
        Axios.get(uri).then((response) => {
            this.composition =  response.data;
        }).catch((e) => {
            console.log(e, 'deu ruim ao obter dados');
        });        
    },
    methods: {
        updateComposition () {
            let uri = this.basepath + '/compositions/' + this.$route.params.id;
            Axios.put(uri, this.composition).then((response) => {
                this.$router.push({name: 'ListComposition'})
            })
        }
    }
}
</script>

