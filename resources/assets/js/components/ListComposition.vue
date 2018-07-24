<template id="composition-list">
    <div class="row">
        <div class="col-md-12 text-right mt-3 mb-4">
            <router-link class="btn btn-xs btn-primary" :to="{name: 'AddComposition'}">            
                Adicionar nova composição
            </router-link>
        </div>
        <br><br>
        <table class="table table-bordered">
            <thead>
                <tr>
                    <th>#</th>
                    <th>Nome da composição</th>
                    <th>Conteúdo</th>
                    <th>Opções</th>
                </tr>
            </thead>
            <tbody>
                <tr v-for="(composition, index) in filteredCompositions" :key="composition.id">
                    <td>{{ index + 1 }}</td>
                    <td>{{ composition.title }}</td>
                    <td>{{ composition.body }} </td>
                    <td>
                        <router-link class="btn btn-xs btn-info" :to="{name: 'ViewComposition', params: {id: composition.id}}"> Visualizar </router-link>
                        <router-link class="btn btn-xs btn-warning" :to="{name: 'EditComposition', params: {id: composition.id}}"> Editar </router-link>
                        <router-link class="btn btn-xs btn-danger" :to="{name: 'DeleteComposition', params: {id: composition.id}}"> Excluir </router-link>
                    </td>
                </tr>
            </tbody>
        </table>
    </div>
</template>

<script>
export default {
    data () {
        return {
            compositions: ''
        }
    },
    created () {
        let uri = 'http://localhost:8000/compositions';
        Axios.get(uri).then((response) => {
            this.compositions = response.data;
        }).catch(() => {
            console.log('Não conseguiu obter dados do servidor');
        });
    },
    computed: {
        filteredCompositions () {
            if(this.compositions.length) {
                return this.compositions;
            }
        }
    }
}
</script>