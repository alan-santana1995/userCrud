<template>
    <div class="container">
        <div id="user-data-container">
            <div class="user-data-row">
                <span class="user-data-col">Nome: </span>
                <span class="user-data-col">{{ name }}</span>
            </div>
            <div class="user-data-row">
                <span class="user-data-col">E-mail: </span>
                <span class="user-data-col">{{ email }}</span>
            </div>
            <div class="user-data-row">
                <span class="user-data-col">CPF: </span>
                <span class="user-data-col">{{ document }}</span>
            </div>
            <div class="user-data-row">
                <span class="user-data-col">Data de Nascimento: </span>
                <span class="user-data-col">{{ birth_date }}</span>
            </div>
            <div class="user-data-row">
                <span class="user-data-col">Telefone: </span>
                <span class="user-data-col">{{ phone_number }}</span>
            </div>
            <div class="user-data-row">
                <span class="user-data-col">Status: </span>
                <span class="user-data-col">{{ status ? 'Ativo' : 'Inativo' }}</span>
            </div>
            <div class="user-data-row">
                <span class="user-data-col">CEP: </span>
                <span class="user-data-col">{{ zip_code }}</span>
            </div>
            <div class="user-data-row">
                <span class="user-data-col">Estado: </span>
                <span class="user-data-col">{{ uf }}</span>
            </div>
            <div class="user-data-row">
                <span class="user-data-col">Cidade: </span>
                <span class="user-data-col">{{ city }}</span>
            </div>
            <div class="user-data-row">
                <span class="user-data-col">Bairro: </span>
                <span class="user-data-col">{{ neighborhood }}</span>
            </div>
            <div class="user-data-row">
                <span class="user-data-col">Endereço: </span>
                <span class="user-data-col">{{ address }}</span>
            </div>
        </div>
        <div id="user-data-footer">
            <button class="btn" @click.prevent="back()">
                Voltar
            </button>
        </div>
    </div>
</template>

<script>
import {formatCpf, formatDate, formatPhoneNumber, formatZipCode, getUfName} from '../utils';

export default {
    props: [
        'id'
    ],
    data() {
        return {
            name: '',
            email: '',
            document: '',
            birth_date: '',
            phone_number: '',
            zip_code: '',
            uf: '',
            city: '',
            neighborhood: '',
            address: '',
            status: false
        }
    },
    created() {
        apiAxios.get(`/api/users/${this.id}`)
            .then((response) => {
                let data = response.data;

                this.name = data.name;
                this.email = data.email;
                this.document = formatCpf(data.document);
                this.birth_date = formatDate(data.birth_date);
                this.phone_number = formatPhoneNumber(data.phone_number);
                this.zip_code = formatZipCode(data.zip_code);
                this.uf = getUfName(data.uf);
                this.city = data.city;
                this.neighborhood = data.neighborhood;
                this.address = data.address;
                this.status = data.status;
            })
            .catch(
                (error) => {
                    console.error(error);
                    this.$toast.error('Ocorreu um erro ao obter os dados do usuário.')
                }
            )
    },
    methods: {
        back() {
            window.location = '/users'
        }
    }
}
</script>

<style>
    #user-data-footer {
        display: flex;
        flex-direction: row-reverse;
        margin-top: 10px;
    }

    .user-data-row {
        display: flex;
        justify-content: space-between;
        gap: 20px;
        border-bottom: 1px solid #00000024;
        padding: 10px 0;
    }
</style>
