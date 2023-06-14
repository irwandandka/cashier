<template>
    <div>
        <h1 class="h3 mb-4 text-gray-800">Edit Transaction</h1>

        <div class="row justify-content-center">
            <div class="col-md-10">
                <div class="card">
                    <div class="card-header">Transaction Form</div>
                    <div class="card-body">
                        <form @submit.prevent="updateOrder()"> 
                            <div class="row mb-3">
                                <div class="col-md-6">
                                    <label for="customer_id">Customer</label>
                                    <select name="customer_id" id="customer_id" class="form-control" @change="showCustomer()" v-model="form.customer">
                                        <option value="">Open this select menu</option>
                                        <option v-for="customer in customers" :key="customer.id" :value="customer.id">
                                            {{ customer.name }}
                                        </option>
                                    </select>
                                </div>
                                <div class="col-md-6">
                                    <label for="city">City</label>
                                    <input type="text" id="city" v-model="form.city" class="form-control">
                                </div>
                            </div>
                            <div class="row mb-3">
                                <div class="col-md-4">
                                    <label for="subtotal">Subtotal</label>
                                    <input type="text" id="subtotal" v-model="form.subtotal" class="form-control">
                                </div>
                                <div class="col-md-4">
                                    <label for="discount">Discount</label>
                                    <input type="text" id="discount" @keyup="handleDiscount" v-model="form.discount" class="form-control">
                                </div>
                                <div class="col-md-4">
                                    <label for="total">Total</label>
                                    <input type="text" id="total" v-model="form.total" class="form-control">
                                </div>
                            </div>
                            <div>
                            <button type="submit" class="btn btn-primary rounded float-right">Update Transaction</button>
                            </div>
                        </form>
                        <button type="button" @click="showOrderDetailCard" class="btn btn-primary rounded"><i class="fas fa-plus"></i></button>
                        <div class="p-3"> 
                            <div class="row mb-4" v-show="showOrderDetailForm">
                                <div class="card">
                                    <div class="card-body">
                                        <div class="input-group mb-3">
                                            <div class="row">
                                                <div class="col-md-6">
                                                    <label for="item" class="form-label">Item Name</label>
                                                    <select id="item" class="form-control" v-model="orderDetailForm.code">
                                                        <option>Open this select menu</option>
                                                        <option v-for="item in items" :key="item.id" :value="item.code">
                                                            {{ item.name }}
                                                        </option>
                                                    </select>
                                                </div>
                                                <div class="col-md-6">
                                                    <label for="qty" class="form-label">Quantity</label>
                                                    <input type="text" @keyup="updatePrice" class="form-control" v-model="orderDetailForm.qty">
                                                </div>
                                                <div class="col-md-6">
                                                    <label for="price" class="form-label">Price</label>
                                                    <input type="text" @keyup="updatePrice" class="form-control" v-model="orderDetailForm.price">
                                                </div>
                                                <div class="col-md-6">
                                                    <label for="total" class="form-label">Total Price</label>
                                                    <input type="text" class="form-control" v-model="orderDetailForm.total">
                                                </div>
                                            </div>
                                        </div>
                                        <button @click="addOrderDetail" class="btn btn-info rounded float-right">{{ editOrderDetail ? 'Update' : 'Add' }}</button>
                                    </div>
                                </div>
                            </div>
                            <div class="row">
                                <table class="table table-striped table-hovered text-center table-bordered">
                                    <thead>
                                        <tr>
                                            <th>Code</th>
                                            <th>Quantity</th>
                                            <th>Price</th>
                                            <th>Total Price</th>
                                            <th>Action</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <tr v-for="detail in order_detail" :key="detail.code">
                                            <td>{{ detail.code }}</td>
                                            <td>{{ detail.qty }}</td>
                                            <td>{{ formatRupiah(detail.price) }}</td>
                                            <td>{{ formatRupiah(detail.total) }}</td>
                                            <td>
                                                <button class="btn btn-success" @click="handleEditOrderDetail(detail.code)"><i class="fas fa-pen"></i></button>
                                                <button class="btn btn-danger" @click="handleDeleteOrderDetail(detail.code)"><i class="fas fa-trash"></i></button>
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
    </div>
</template>

<script>
import axios from 'axios'

export default {
    data() {
        return {
            customers: [],
            items: [],
            order_detail: [],
            orderId: null,
            currentSelectedOrderDetail: [],
            showOrderDetailForm: false,
            editOrderDetail: false,
            itemId: null,
            form: {
                customer: null,
                city: "",
                date: "",
                subtotal: 0,
                discount: 0,
                total: 0
            },
            orderDetailForm: {
                code: null,
                qty: 0,
                price: 0,
                total: 0,
            }
        }
    },
    created() {
        this.getTransactions();
        this.getCustomers();
        this.getItems();
    },
    methods: {
        getTransactions() {
            axios.get(`/api/transactions/${this.$route.params.id}`)
                .then(res => {
                    let transaction = res.data;
                    this.form.customer = transaction.customer_id;
                    this.form.city = transaction.customer.city
                    this.form.subtotal = transaction.subtotal;
                    this.form.discount = transaction.discount;
                    this.form.total = transaction.total;
                    this.orderId = transaction.id;
                    transaction.order_items.map(item => {
                        // let data = {
                            
                        // }
                        this.order_detail.push({ 
                            id: item.id,
                            item_id: item.item_id,
                            code: item.code,
                            qty: item.qty,
                            price: item.price,
                            total: item.total,
                         })
                    })
                })
                .catch(error => console.log(error.response.data.message))
        },
        getCustomers() {
            axios.get('/api/transaction/customers')
                .then(res => this.customers = res.data)
                .catch(error => console.log(error.response.data.message))
        },
        getItems() {
            axios.get('/api/transaction/items')
                .then(res => {
                    this.items = res.data;
                })
                .catch(error => console.log(error.response.data.message));
        },
        showCustomer() {
            axios.get(`/api/transaction/customers/${this.form.customer}`)
                .then(res => {
                    this.form.city = res.data.city
                })
        },
        updatePrice() {
            let total = this.orderDetailForm.qty * this.orderDetailForm.price;
            this.orderDetailForm.total = total;
        },
        showOrderDetailCard() {
            this.showOrderDetailForm = true;
        },
        addOrderDetail() {
            let selectedItem = this.items.filter(item => item.code === this.orderDetailForm.code);
            this.itemId = selectedItem[0].id;
            let { id = this.itemId, code, total } = this.orderDetailForm;
            let qty = parseInt(this.orderDetailForm.qty);
            let price = parseInt(this.orderDetailForm.price);
            if(this.editOrderDetail) {
                let orderDetailIndex = this.order_detail.findIndex(data => data.code === this.orderDetailForm.code);
                if(orderDetailIndex !== -1) {
                    this.order_detail[orderDetailIndex] = {
                        ...this.order_detail[orderDetailIndex],
                        id,
                        code,
                        qty,
                        price,
                        total
                    }
                }
                this.form.subtotal -= this.currentOrderDetailTotal;
                this.form.subtotal += total;
                this.form.total = this.form.subtotal;
                this.editOrderDetail = false
            } else {
                this.order_detail.push({ id, code, qty, price, total });
                this.form.subtotal += total;
                this.form.total = this.form.subtotal;
            }
            this.resetOrderDetailInput();
            this.showOrderDetailForm = false;
        },
        resetOrderDetailInput() {
            this.itemId = null;
            this.orderDetailForm.code = null;
            this.orderDetailForm.qty = 0;
            this.orderDetailForm.price = 0;
            this.orderDetailForm.total = 0;
        },
        formatRupiah(value) {
            return new Intl.NumberFormat("id-ID", {
                style: "currency",
                currency: "IDR"
            }).format(value)
        },
        handleDiscount() {
            let discountPrice = (this.form.discount / 100) * this.form.subtotal 
            this.form.total = this.form.subtotal - discountPrice;
        },
        handleEditOrderDetail(code) {
            this.showOrderDetailForm = true;
            this.editOrderDetail = true;
            let orderDetail = this.order_detail.filter(data => data.code === code);
            this.orderDetailForm = orderDetail[0];
            this.currentOrderDetailTotal = this.orderDetailForm.total;
        },
        handleDeleteOrderDetail(code) {
            let orderDetailIndex = this.order_detail.findIndex(data => data.code === code);
            let orderDetail = this.order_detail.filter(data => data.code === code);
            this.order_detail.splice(orderDetailIndex, 1);
            this.form.subtotal -= orderDetail[0].total;
            this.form.total = this.form.subtotal;
        },
        updateOrder() {
            axios.put(`/api/transactions/${this.orderId}`, {
                    customer_id: this.form.customer,
                    subtotal: this.form.subtotal,
                    discount: this.form.discount,
                    total: this.form.total,
                    order_detail: this.order_detail
                })
                .then(res => {
                    this.$router.push({name: 'TransactionIndex'})
                })
                .catch(error => console.log(error.response.data.message));
        } 
    }
}
</script>

<style>

</style>