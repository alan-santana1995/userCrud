import axios from 'axios';

window.apiAxios = axios.create();
window.viaCepAxios = axios.create({
    baseURL: process.env.MIX_VIA_CEP_API_URL
});

window.apiAxios.defaults.headers.common['X-Requested-With'] = 'XMLHttpRequest';

window.viaCepAxios.defaults.headers.common['X-Requested-With'] = 'XMLHttpRequest';
