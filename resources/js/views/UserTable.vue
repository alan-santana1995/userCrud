<template>
    <table @user-updated="updateUsersTable" id="user-table">
        <thead>
            <tr>
                <th>Nome</th>
                <th>E-mail</th>
                <th>CPF</th>
                <th>Data de Nascimento</th>
                <th>Telefone</th>
                <th>CEP</th>
                <th>Estado</th>
                <th>Cidade</th>
                <th>Bairro</th>
                <th>Endereço</th>
                <th>Situação</th>
                <th>#</th>
            </tr>
        </thead>
        <tbody :hidden="loading">
            <user-row
                v-for="(user) in users"
                :key="user.id"
                :user="user"
            >
            </user-row>
        </tbody>
        <tbody :hidden="!loading">
            <tr>
                <td id="user-table-loading" colspan="12">
                    Carregando...
                </td>
            </tr>
        </tbody>
        <tfoot>
            <tr>
                <td colspan="12">
                    <div id="user-table-page-information">
                        Mostrando itens do {{ from }} até o {{ to }} do total de {{ total }}
                    </div>
                </td>
            </tr>
            <tr>
                <td colspan="12">
                    <div id="user-table-pagination-control">
                        <div id="user-table-pagination-control-left">
                            <button :disabled="page === 1" @click.prevent="updateUsersTable(1)">&lt;&lt;</button>
                            <button :disabled="page === 1" @click.prevent="updateUsersTable(page-1)">&lt;</button>
                        </div>
                        <div id="user-table-pagination-control-center">
                            Página {{ page }} de {{ lastPage }}
                        </div>
                        <div id="user-table-pagination-control-right">
                            <button :disabled="page === lastPage" @click.prevent="updateUsersTable(page+1)">&gt;</button>
                            <button :disabled="page === lastPage" @click.prevent="updateUsersTable(lastPage)">&gt;&gt;</button>
                        </div>
                    </div>
                </td>
            </tr>
        </tfoot>
    </table>
</template>

<script>
import UserRow from './UserRow.vue'

export default {
    data() {
        return {
            users: [],
            page: 1,
            lastPage: 1,
            from: 1,
            to: 1,
            total: 1,
            perPage: 10,
            loading: true
        }
    },
    components: {
        UserRow
    },
    mounted() {
        this.updateUsersTable(this.page)
    },
    methods: {
        updateUsersTable(page) {
            this.loading = true
            apiAxios.get(`/api/users?page=${page}&page_size=${this.perPage}`)
                .then((response) => {
                    let data = response.data;
                    this.users = data.data;

                    this.page = data.current_page;
                    this.lastPage = data.last_page;
                    this.from = data.from;
                    this.to = data.to;
                    this.total = data.total;

                    this.loading = false;
                })
                .catch((error) => {
                    console.error(error);
                    this.loading = false;

                })
        },
        criarNovoUsuario() {
            window.location = '/users/create'
        },

    }
}
</script>

<style>
table#user-table {
    width: 90rem;
    height: 50rem;
    border: 1px solid #bfbfbf;
    border-radius: 5px;
    margin-top: 10px;
}

#user-table > thead > tr > th:not(:last-child) {
    border-right: 1px solid #cdcdcd;
    padding: 5px;
}

.user-table-column {
    border-bottom: 1px solid #bfbfbf;
    padding: 1px 10px;
}

.user-table-row:hover {
    background-color: #ededed;
}

.user-table-row:first-child > .user-table-column {
    border-top: 1px solid #bfbfbf;
}

.user-table-column:not(:last-child) {
    border-right: 1px solid #bfbfbf;
}

#user-table-loading {
    width: 100%;
    height: 100%;
    text-align: center;
    font-size: 2rem;
}

#user-table-page-information {
    display: flex;
    flex-direction: row-reverse;
    margin-top: 10px;
}

#user-table-pagination-control {
    display: flex;
    flex-direction: row;
    justify-content: center;
    column-gap: 10px;
    padding: 10px 0;
}

#user-table-pagination-control > div {
    display: flex;
    gap: 5px;
}

#user-table-pagination-control > div > button {
}

#user-table-pagination-control-center {
    display: flex;
    align-items: center;
}
</style>
