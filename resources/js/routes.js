import TransactionIndex from './components/transaction/TransactionIndex.vue';
import TransactionCreate from './components/transaction/TransactionCreate.vue';
import TransactionEdit from './components/transaction/TransactionEdit.vue';

export const routes = [
    {
        path: "/transaction",
        name: "TransactionIndex",
        component: TransactionIndex
    },
    {
        path: "/transaction/create",
        name: "TransactionCreate",
        component: TransactionCreate
    },
    {
        path: "/transaction/edit",
        name: "TransactionEdit",
        component: TransactionEdit
    }
]