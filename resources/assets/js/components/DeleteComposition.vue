<template id="delete-composition">
    <div>
        <h3>Deletar composição <strong>{{ composition.title }}</strong></h3>
        <form @submit.prevent="deleteComposition">
            <p>A deleção não poderá ser desfeita.</p>
            <button class="btn btn-xs btn-danger" type="submit">Deletar</button>
            <router-link class="btn btn-xs btn-primary" v-bind:to="'/'">Voltar</router-link>
        </form>
    </div>
</template>

<script>
import mixin from '../mixins';
export default {
    mixins: [mixin],
    data () {
        return {
            composition: { title: '', body: '' }
        }
    },
    created () {
        let uri = this.basepath + '/compositions/' + this.$route.params.id + '/edit'
        Axios.get(uri).then((response) => {
            this.composition =  response.data;
        });
    },
    methods: {
        deleteComposition () {
            let uri = this.basepath + '/compositions/' + this.$route.params.id;
            Axios.delete(uri).then((response) => {
                this.$router.push({name: 'ListComposition'})
            }).catch((e) => {
                console.log('ERRO: ', e)
            })
        }
    }
}
</script>