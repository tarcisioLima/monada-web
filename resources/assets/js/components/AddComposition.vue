<template id="add-composition">
    <div>
        <h3>Transcreva uma nova composição</h3>
        <form @submit.prevent = "createComposition">
            <div class="form-group">
                <label for="add-title">Titulo</label>
                <input type="text" id="add-title" v-model="composition.title" class="form-control" required>
            </div>
            <div class="form-group">
                <label for="add-body">Conteúdo</label>
                <textarea rows="10" id="add-body" v-model="composition.body" class="form-control" required></textarea>
            </div>
            <button type="submit" class="btn btn-xs btn-primary">Postar</button>
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
    methods: {
        createComposition () {
            let uri = this.basepath + '/compositions';
            Axios.post(uri, this.composition).then((response) => {
                //this.$router.push({name: 'ListComposition'})
            }).catch((e) => {
                console.log(e, 'deu ruim ao enviar post');
            });
        }
    }
}
</script>

