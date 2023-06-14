<template>
    <div>
        <h1 class="h3 mb-4 text-gray-800">Transaction Page</h1>

        <div class="row justify-content-center">
            <div class="col-md-10">
                <div class="card shadow rounded">
                    <div class="card-header">Transaction Data</div>
                    <div class="card-body">
                        
                        <router-link class="btn btn-primary rounded mb-4" :to="{name: 'TransactionCreate'}">
                            Create
                        </router-link>

                        <div class="table-responsive">
                            <table class="table table-striped table-hover table-borderless">
                                <thead class="text-center">
                                    <tr>
                                        <th>#</th>
                                        <th>Name</th>
                                        <th>City</th>
                                        <th>Subtotal</th>
                                        <th>Discount</th>
                                        <th>Total</th>
                                        <th>Date</th>
                                        <th>Action</th>
                                    </tr>
                                </thead>
                                <tbody>
                                        <tr class="text-center" v-for="(transaction, index) in transactions" :key="transaction.id">
                                            <td>{{ index + 1 }}</td>
                                            <td>{{ transaction.customer.name }}</td>
                                            <td>{{ transaction.customer.city }}</td>
                                            <td>{{ formatRupiah(transaction.subtotal) }}</td>
                                            <td>{{ transaction.discount }}%</td>
                                            <td>{{ formatRupiah(transaction.total) }}</td>
                                            <td>{{ transaction.date }}</td>
                                            <td>
                                                <button type="button" class="btn btn-info rounded" @click="showTransactionDetail(transaction.id)" data-toggle="modal" data-target="#showTransactionDetail">
                                                    Detail
                                                </button>

                                                <div class="modal fade" id="showTransactionDetail" tabindex="-1" aria-labelledby="showTransactionDetailLabel" aria-hidden="true">
                                                    <div class="modal-dialog">
                                                    <div class="modal-content">
                                                        <div class="modal-header">
                                                        <h5 class="modal-title" id="showTransactionDetailLabel">Create New Customer</h5>
                                                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                                            <span aria-hidden="true">&times;</span>
                                                        </button>
                                                        </div>
                                                        <div class="modal-body">
                                                            <table class="table table-striped table-hovered text-center table-bordered">
                                                                <thead>
                                                                    <tr>
                                                                        <th>Code</th>
                                                                        <th>Quantity</th>
                                                                        <th>Price</th>
                                                                        <th>Total Price</th>
                                                                    </tr>
                                                                </thead>
                                                                <tbody>
                                                                    <tr v-for="detail in transactionOrderDetail" :key="detail.data.code">
                                                                        <td>{{ detail.data.code }}</td>
                                                                        <td>{{ detail.data.qty }}</td>
                                                                        <td>{{ formatRupiah(detail.data.price) }}</td>
                                                                        <td>{{ formatRupiah(detail.data.total) }}</td>
                                                                    </tr>
                                                                </tbody>
                                                            </table>
                                                        </div>
                                                    </div>
                                                    </div>
                                                </div>
                                                <router-link :to="{name: 'TransactionEdit', params: {id: transaction.id}}" class="btn btn-success rounded">Edit</router-link>
                                                <button class="btn btn-danger rounded" @click="handleDeleteTransaction(transaction.id)">Delete</button>
                                            </td>
                                        </tr>
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

  
</template>

<script>
import axios from 'axios';

export default {
    data() {
        return {
            transactions: [],
            transactionOrderDetail: []
        }
    },
    created() {
        this.getTransactions();
    },
    methods: {
        getTransactions() {
            axios.get('/api/transactions')
                .then(res => {
                    this.transactions = res.data
                })
                .catch(error => console.log(error.response.data.message));
        },
        handleDeleteTransaction(id) {
            axios.delete(`/api/transactions/${id}`)
                .then(res => {
                    this.getTransactions()
                })
                .catch(error => console.log(error.response.data.message));
        },
        showTransactionDetail(id) {
            axios.get(`/api/transactions/${id}`)
                .then(res => {
                    this.transactionOrderDetail = [];
                    let transactionDetails = res.data.order_items;
                    transactionDetails.forEach(detail => {
                        let data = {
                            id: detail.id,
                            item_id: detail.item_id,
                            code: detail.code,
                            qty: detail.qty,
                            price: detail.price,
                            total: detail.total,
                        }
                        this.transactionOrderDetail.push({ data })
                    })
                })
                .catch(error => console.log(error.response.data.message))
        },
        formatRupiah(value) {
            return new Intl.NumberFormat("id-ID", {
                style: "currency",
                currency: "IDR"
            }).format(value)
        },
    }
}
</script>