<template>
    <span> Nome: </span>
    <input
        type="text"
        ref="name"
        v-model.lazy.trim="form.name"
        name="name"
        :disabled="disableForm"
    >
    <br>
    <span> E-mail: </span>
    <input
        type="email"
        ref="email"
        v-model.lazy.trim="form.email"
        name="email"
        :disabled="disableForm"
    >
    <br>
    <span>CPF:</span>
    <input
        type="text"
        ref="document"
        v-model.lazy.trim="form.document"
        name="document"
        :disabled="disableForm"
    >
    <br>
    <span> Data de Nascimento: </span>
    <input
        type="date"
        ref="birthDate"
        v-model.lazy.trim="form.birth_date"
        name="birth_date"
        :disabled="disableForm"
    >
    <br>
    <span> Telefone: </span>
    <input
        type="text"
        ref="phoneNumber"
        v-model.lazy.trim="form.phone_number"
        name="phone_number"
        :disabled="disableForm"
    >
    <br>
    <span> CEP: </span>
    <input
        type="text"
        ref="zipCode"
        v-model.lazy.trim="form.zip_code"
        name="zip_code"
        :disabled="disableForm || validatingCep"
    >
    <br>
    <span>Status:</span>
    <input
        type="checkbox"
        ref="status"
        name="status"
        v-model="form.status"
    >
    <br>
    <span> Estado: </span>
    <input
        type="text"
        ref="uf"
        v-model="zip_code_info.uf"
        name="uf" disabled
    >
    <br>
    <span> Cidade: </span>
    <input
        type="text"
        ref="city"
        v-model="zip_code_info.city"
        name="city" disabled
    >
    <br>
    <span> Bairro: </span>
    <input
        type="text"
        ref="neighborhood"
        v-model="zip_code_info.neighborhood"
        name="neighborhood" disabled
    >
    <br>
    <span> Endereço: </span>
    <input
        type="text"
        ref="address"
        v-model="zip_code_info.address"
        name="address" disabled
    >
    <br>
    <button
        :disabled="!(validZipCode && validDocument && validEmail)"
        @click.prevent="submit()"
    >
        Salvar
    </button>
</template>

<script>

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
        },
        'form.zip_code'(newVal, oldVal) {
            if (typeof oldVal === undefined || newVal === '') {
                return;
            }
            this.validatingCep = true;
            newVal = newVal.replace(/\D/g, '');
            if (newVal.length !== 8) {
                this.$toast.error('O CEP informado não é válido');
                this.validatingCep = false;
                this.$refs.zip_code.focus();
                return;
            }
            viaCepAxios.get(`/${newVal}/json`)
                .then((response) => {
                    this.validatingCep = false;
                    if (typeof response.data.erro !== undefined && response.data.erro === "true") {
                        this.$toast.error('O CEP informado não é válido')
                        this.validZipCode = false;
                        this.$refs.zip_code.focus()
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
                    this.validatingCep = false;
                    this.$toast.error('Ocorreu um erro ao tentar validar seu CEP, tente novamente...')
                })
        }
    },
    methods: {
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
        startLoading() {
            this.disableForm = true;
        },
        stopLoading() {
            this.disableForm = false;
        },
        submit() {
            this.startLoading();

            if (this.form.name.length === 0) {
                this.$toast.error('Nenhum nome informado!');
                this.$refs.name.focus();
                return;
            }

            if (this.form.email.length === 0) {
                this.$toast.error('Nenhum e-mail informado!');
                this.$refs.email.focus();
                return;
            }

            if (this.form.birth_date.length === 0) {
                this.$toast.error('Nenhuma data de nascimento informada!');
                this.$refs.birthDate.focus();
                return;
            }

            if (this.form.document.length === 0) {
                this.$toast.error('Nenhum nome informado!');
                this.$refs.document.focus();
                return;
            }

            if (this.form.phone_number.length === 0) {
                this.$toast.error('Nenhum Telefone informado!');
                this.$refs.phoneNumber.focus();
                return;
            }

            if (this.form.zip_code.length === 0) {
                this.$toast.error('Nenhum CEP informado!');
                this.$refs.zipCode.focus();
                return;
            }

            if (this.id) {
                this.updateUser()
                return;
            }

            this.createUser();
        },
        updateUser() {
            apiAxios.put(`/api/users/${this.id}`, this.form)
                .then((response) => {
                    this.$toast.success('Usuário atualizado com sucesso.')
                    this.stopLoading();
                    setTimeout(
                        () => window.location = `/users/${this.id}`,
                        5000
                    );
                })
                .catch((error) => {
                    this.stopLoading();
                    if (typeof error.data.message !== undefined) {
                        this.$toast.error(error.data.message);
                        return;
                    }

                    this.$toast.error('Ocorreu um erro ao tentar atualizar o usuário');
                });
        },
        createUser() {
            apiAxios.post(`/api/users`,this.form)
                .then((response) => {
                    this.$toast.success('Usuário criado com sucesso.')
                    this.stopLoading();
                    setTimeout(
                        () => window.location = `/users/${response.data.id}`,
                        5000
                    );
                })
                .catch((error) => {
                    this.stopLoading();
                    if (typeof error.data.message !== undefined) {
                        this.$toast.error(error.data.message);
                        return;
                    }

                    this.$toast.error('Ocorreu um erro ao tentar criar o novo usuário');
                });
        },
        requestUserData() {
            this.startLoading();
            apiAxios.get(`/api/users/${this.id}`)
                .then((response) => {
                    this.stopLoading();
                    this.loadFormData(response.data)
                })
                .catch((error) => {
                    this.stopLoading();

                    if (typeof error.data !== 'undefined') {
                        this.$toast.error(error.data.message)
                        return false;
                    }
                })
        },
        loadFormData(user) {
            this.form.name = user.name;
            this.form.email = user.email;
            this.form.document = user.document;
            this.form.birth_date = user.birth_date;
            this.form.phone_number = user.phone_number;
            this.form.zip_code = user.zip_code;
        }
    }
}
</script>
