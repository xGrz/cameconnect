import {AxiosInstance} from 'axios';

declare global {
    interface Window {
        axios: AxiosInstance;
    }

    // ZIGGY
    function route(name?: string, params?: object, absolute?: boolean): string;


}

