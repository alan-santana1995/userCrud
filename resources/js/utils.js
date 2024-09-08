const ufMap = {
    "AC": "Acre",
    "AL": "Alagoas",
    "AP": "Amapá",
    "AM": "Amazonas",
    "BA": "Bahia",
    "CE": "Ceará",
    "DF": "Distrito Federal",
    "ES": "Espírito Santo",
    "GO": "Goiás",
    "MA": "Maranhão",
    "MT": "Mato Grosso",
    "MS": "Mato Grosso do Sul",
    "MG": "Minas Gerais",
    "PA": "Pará",
    "PB": "Paraíba",
    "PR": "Paraná",
    "PE": "Pernambuco",
    "PI": "Piauí",
    "RJ": "Rio de Janeiro",
    "RN": "Rio Grande do Norte",
    "RS": "Rio Grande do Sul",
    "RO": "Rondônia",
    "RR": "Roraima",
    "SC": "Santa Catarina",
    "SP": "São Paulo",
    "SE": "Sergipe",
    "TO": "Tocantins",
}

module.exports = {
    formatCpf(cpf) {
        return cpf.replace(/(\d{3})(\d{3})(\d{3})(\d{2})/, "$1.$2.$3-$4")
    },
    formatPhoneNumber(phoneNumber) {
        return phoneNumber.replace(/(\d{2})(\d{4})(\d{4})/, "($1) $2-$3")
    },
    formatZipCode(zipCode) {
        return zipCode.replace(/(\d{5})(\d{2})/, "$1-$2")
    },
    formatDate(date) {
        return (new Date(date)).toLocaleDateString()
    },
    getUfName(acronym) {
        return ufMap[acronym] ?? '--';
    }
}
