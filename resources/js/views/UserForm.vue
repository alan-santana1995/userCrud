<template>
    <div id="user-form-main-wrapper" class="container">
        <div id="user-form-header">
            <h1 v-if="!this.id">
                Cadastro de usuário
            </h1>
            <h1 v-if="this.id">
                Atualizando usuário
            </h1>
        </div>
        <hr>
        <div id="user-form-body">
            <div id="user-form-status-container" class="user-form-row-item">
                <span>Status:</span>
                <input
                    type="checkbox"
                    ref="status"
                    name="status"
                    v-model="form.status"
                >
            </div>
            <div class="user-form-row-item">
                <span> Nome: </span>
                <br>
                <input
                    type="text"
                    ref="name"
                    v-model.lazy.trim="form.name"
                    name="name"
                    :disabled="disableForm"
                >
            </div>
            <div class="user-form-row-item">
                <span> E-mail: </span>
                <br>
                <input
                    type="email"
                    ref="email"
                    v-model.lazy.trim="form.email"
                    name="email"
                    :disabled="disableForm"
                >
            </div>
            <div class="user-form-row-item">
                <span>CPF:</span>
                <br>
                <input
                    type="text"
                    ref="document"
                    placeholder="123.456.789-00"
                    maxlength="11"
                    title="CPF (somente números)"
                    v-model.lazy.trim="form.document"
                    name="document"
                    :disabled="disableForm"
                >
            </div>
            <div class="user-form-row-item">
                <span> Data de Nascimento: </span>
                <br>
                <input
                    type="date"
                    ref="birthDate"
                    v-model.lazy.trim="form.birth_date"
                    name="birth_date"
                    :disabled="disableForm"
                >
            </div>
            <div class="user-form-row-item">
                <span> Telefone: </span>
                <br>
                <input
                    type="text"
                    ref="phoneNumber"
                    placeholder="11 1234-5678"
                    title="Telefone (somente números)"
                    maxlength="10"
                    v-model.lazy.trim="form.phone_number"
                    name="phone_number"
                    :disabled="disableForm"
                >
            </div>
            <div class="user-form-row-item">
                <span> CEP: </span>
                <br>
                <input
                    type="text"
                    ref="zipCode"
                    title="Cep (somente números)"
                    maxlength="8"
                    v-model.lazy.trim="form.zip_code"
                    name="zip_code"
                    @change="validateZipCode()"
                    :disabled="disableForm || validatingCep"
                >
            </div>
            <div class="user-form-row-item">
                <span> Estado: </span>
                <br>
                <input
                    type="text"
                    ref="uf"
                    v-model="zip_code_info.uf"
                    name="uf" disabled
                >
            </div>
            <div class="user-form-row-item">
                <span> Cidade: </span>
                <br>
                <input
                    type="text"
                    ref="city"
                    v-model="zip_code_info.city"
                    name="city" disabled
                >
            </div>
            <div class="user-form-row-item">
                <span> Bairro: </span>
                <br>
                <input
                    type="text"
                    ref="neighborhood"
                    v-model="zip_code_info.neighborhood"
                    name="neighborhood" disabled
                >
            </div>
            <div class="user-form-row-item">
                <span> Endereço: </span>
                <br>
                <input
                    type="text"
                    ref="address"
                    v-model="zip_code_info.address"
                    name="address" disabled
                >
            </div>
        </div>
        <hr>
        <div id="user-form-footer">
            <button
                id="user-form-submit-btn"
                class="btn"
                :disabled="!(validZipCode && validDocument && validEmail) || disableForm"
                @click.prevent="submit()"
            >
                Salvar
            </button>
        </div>
    </div>
</template>

<script>
import { formatCpf, getUfName } from '../utils';

export default {
    props: {
        id: null
    },
    data() {
        return {
            form: {
                name: '',
                email: '',
                document: '',
                birth_date: '',
                phone_number: '',
                zip_code: '',
                status: false,
            },
            zip_code_info: {
                uf: '',
                city: '',
                neighborhood: '',
                address: '',
            },
            validZipCode: false,
            validDocument: false,
            validEmail: false,
            validatingCep: false,
            disableForm: false,
            invalidDocumentErrorMessage: 'O CPF informado não é válido'
        };
    },
    mounted() {
        if (this.id) {
            this.requestUserData();
            this.validDocument = this.validEmail = this.validZipCode = true;
        }

        this.$refs.name.focus()
    },
    watch: {
        'form.email'(newVal, oldVal) {
            if (typeof oldVal === undefined || newVal === '') {
                return;
            }
            // https://gist.github.com/gregseth/5582254
            this.validEmail = newVal.match(
                /(?:[a-z0-9!#$%&'*+/=?^_`{|}~-]+(?:\.[a-z0-9!#$%&'*+/=?^_`{|}~-]+)*|"(?:[\x01-\x08\x0b\x0c\x0e-\x1f\x21\x23-\x5b\x5d-\x7f]|\\[\x01-\x09\x0b\x0c\x0e-\x7f])*")@(?:(?:[a-z0-9](?:[a-z0-9-]*[a-z0-9])?\.)+[a-z0-9](?:[a-z0-9-]*[a-z0-9])?|\[(?:(?:25[0-5]|2[0-4][0-9]|[01]?[0-9][0-9]?)\.){3}(?:25[0-5]|2[0-4][0-9]|[01]?[0-9][0-9]?|[a-z0-9-]*[a-z0-9]:(?:[\x01-\x08\x0b\x0c\x0e-\x1f\x21-\x5a\x53-\x7f]|\\[\x01-\x09\x0b\x0c\x0e-\x7f])+)\])/i
            )

            if (!this.validEmail) {
                this.$toast.error('O email informado não é válido.')
                this.$refs.email.focus()
            }
        },
        'form.document'(newVal, oldVal) {
            if (typeof oldVal === undefined || newVal === '') {
                return;
            }
            try {
                let document = newVal.replace(/\D+/g, '');

                if (document.length < 11) {
                    throw this.invalidDocumentErrorMessage
                }

                this.validateDocumentValidationDigit(document, 10, 9)
                this.validateDocumentValidationDigit(document, 11, 10)
                this.validDocument = true
            } catch (e) {
                this.$toast.error(e)
                console.error(e)
                this.$refs.document.focus()
            }
        }
    },
    methods: {
        startLoading() {
            this.disableForm = true;
        },
        stopLoading() {
            this.disableForm = false;
        },
        submit() {
            this.startLoading();

            try {
                if (this.form.name.length === 0) {
                    this.$refs.name.focus();
                    throw 'Nenhum nome informado!';
                }

                if (this.form.email.length === 0) {
                    this.$refs.email.focus();
                    throw 'Nenhum e-mail informado!';
                }

                if (this.form.birth_date.length === 0 || new Date(this.form.birth_date) == 'Invalid Date') {
                    this.$refs.birthDate.focus();
                    throw 'Nenhuma data de nascimento informada!';
                }

                if (this.form.document.length === 0) {
                    this.$refs.document.focus();
                    throw 'Nenhum nome informado!';
                }

                if (this.form.phone_number.length === 0) {
                    this.$refs.phoneNumber.focus();
                    throw 'Nenhum Telefone informado!';
                }

                if (this.form.zip_code.length === 0) {
                    this.$refs.zipCode.focus();
                    throw 'Nenhum CEP informado!'
                }
            } catch (e) {
                this.stopLoading();
                this.$toast.error(e);
                return;
            }

            if (this.id) {
                this.updateUser()
                this.stopLoading;
                return;
            }

            this.createUser();
        },
        updateUser() {
            apiAxios.put(`/api/users/${this.id}`, this.form)
                .then(() => {
                    this.$toast.success('Usuário atualizado com sucesso.')
                    setTimeout(
                        () => window.location = `/users/${this.id}`,
                        5000
                    );
                })
                .catch((error) => {
                    this.stopLoading();
                    console.log(error);
                    this.$toast.error('Ocorreu um erro ao tentar atualizar o usuário');
                });
        },
        createUser() {
            apiAxios.post(`/api/users`,this.form)
                .then((response) => {
                    this.$toast.success('Usuário criado com sucesso.')
                    setTimeout(
                        () => window.location = `/users/${response.data.id}`,
                        5000
                    );
                })
                .catch((error) => {
                    this.stopLoading();
                    console.log(error);
                    this.$toast.error('Ocorreu um erro ao tentar criar o novo usuário');
                });
        },
        requestUserData() {
            this.startLoading();
            apiAxios.get(`/api/users/${this.id}`)
                .then((response) => {
                    this.loadFormData(response.data)
                    this.stopLoading();
                })
                .catch((error) => {
                    this.stopLoading();
                    console.log(error);
                    this.$toast.error('Ocorreu um erro ao tentar obter os dados do usuário informado. Recarregue a página.');
                })
        },
        loadFormData(user) {
            this.form.name = user.name;
            this.form.email = user.email;
            this.form.document = user.document;
            this.form.birth_date = user.birth_date;
            this.form.phone_number = user.phone_number;
            this.form.zip_code = user.zip_code;
            this.form.status = user.status;
            this.zip_code_info.uf = getUfName(user.uf);
            this.zip_code_info.city = user.city
            this.zip_code_info.neighborhood = user.neighborhood
            this.zip_code_info.address = user.address;
        },
        validateZipCode() {
            if (this.disableForm) {
                return;
            }
            this.validatingCep = true;
            this.form.zip_code = this.form.zip_code.replace(/\D/g, '');
            if (this.form.zip_code.length !== 8) {
                this.$toast.error('O CEP informado não é válido');
                this.validatingCep = false;
                this.$refs.zip_code.focus();
                return;
            }
            viaCepAxios.get(`/${this.form.zip_code}/json`)
                .then((response) => {
                    this.validatingCep = false;
                    if (typeof response.data.erro !== undefined && response.data.erro === "true") {
                        this.$toast.error('O CEP informado não é válido')
                        this.validZipCode = false;
                        this.$refs.zipCode.focus()
                        return false;
                    }

                    this.validZipCode = true;
                    let data = response.data;

                    this.zip_code_info.uf = data.estado
                    this.zip_code_info.city = data.localidade
                    this.zip_code_info.neighborhood = data.bairro
                    this.zip_code_info.address = data.logradouro;
                    if (data.complemento !== '') {
                        this.zip_code_info.address = this.zip_code_info.address + ' ' + data.complemento
                    }
                })
                .catch((error) => {
                    console.error(error);
                    this.validatingCep = false;
                    this.$toast.error('Ocorreu um erro ao tentar validar seu CEP, tente novamente...')
                })
        },
        validateDocumentValidationDigit(document, weightStartingValue, validationDigitIndex) {
            let sum = 0;
            for (let weight = weightStartingValue, i = 0; weight >= 2;i++,weight--) {
                sum += document[i] * weight;
            }

            let rest = sum % 11;
            let validationDigit = 0;
            if (rest >= 2) {
                validationDigit = 11 - rest;
            }

            if (document[validationDigitIndex] != validationDigit) {
                throw this.invalidDocumentErrorMessage
            }
        },
    }
}
</script>

<style>
    #user-form-header > h1 {
        margin: 0;
    }

    #user-form-body {
        display: flex;
        flex-direction: column;
        gap: 10px;
        margin: 20px 0 20px;
    }

    #user-form-status-container {
        display: flex;
        align-items: center;
    }

    #user-form-footer {
        display: flex;
        flex-direction: row-reverse;
    }

    .user-form-row {
        display: flex;
        flex-direction: column;
        gap: 10px;
    }

    .user-form-row-item:not(#user-form-status-container) > input {
        width: 98%;
        padding: 3px 0 3px 5px;
    }
</style>
