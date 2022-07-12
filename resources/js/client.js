import { RequestManager, Client, HTTPTransport } from "@open-rpc/client-js";

const { rpc, token } = window.__info__

const transport = new HTTPTransport(rpc, {
    headers: {
        Authorization: `Bearer ${token}`,
        Accept: 'application/json',
    }
});

let id = 0;
const requestManager = new RequestManager([transport], () => ++id);

export const client = new Client(requestManager);
