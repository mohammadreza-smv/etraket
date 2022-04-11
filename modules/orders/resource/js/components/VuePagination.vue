<template>

      <ul class="pagination" v-if="pagesNumber.length>1">
        <li v-if="pagination.current_page > 1" class="page-item">
            <a  aria-label="Previous"  class="page-link" v-on:click.prevent="changePage(pagination.current_page - 1)">
                <span aria-hidden="true">«</span>
            </a>
        </li>

        <li v-for="page in pagesNumber" :key="page" :class="[page == pagination.current_page ? 'page-item active': 'page-item']">
            <a  v-on:click.prevent="changePage(page)" class="page-link">{{ replaceNumber(page) }}</a>
        </li>
        <li v-if="pagination.last_page>pagesNumber[(pagesNumber.length-1)]" class="page-item">
            <a class="page-link">...</a>
        </li>

        <li v-if="pagination.last_page>pagesNumber[(pagesNumber.length-1)]" :class="[pagination.last_page == pagination.current_page ? 'page-item active': 'page-item']">
            <a  v-on:click.prevent="changePage(pagination.last_page)" class="page-link">{{ replaceNumber(pagination.last_page) }}</a>
        </li>

        <li v-if="pagination.current_page < pagination.last_page" class="page-item">
            <a  class="page-link" v-on:click.prevent="changePage(pagination.current_page + 1)">
                <span aria-hidden="true">»</span>
            </a>
        </li>
    </ul>

</template>

<script>
    export default {
        name: "VuePagination",
        data(){
            return {
                last:0
            }
        },
        props: {
            pagination: {
                type: Object,
                required: true
            },
            offset: {
                type: Number,
                default: 4
            }
        },
        computed: {
            pagesNumber() {
                if (!this.pagination.to) {
                    return [];
                }
                let from = this.pagination.current_page - this.offset;
                if (from < 1) {
                    from = 1;
                }
                let to = from + (this.offset * 2);
                if (to >= this.pagination.last_page) {
                    to = this.pagination.last_page;
                }
                let pagesArray = [];
                for (let page = from; page <= to; page++) {
                    pagesArray.push(page);
                }
                return pagesArray;
            }
        },
        methods: {
            changePage(page) {
                this.pagination.current_page = page;
                this.$emit('paginate',page);
            },
            replaceNumber: function (n) {
                if (n !==undefined) {
                    n = n.toString();
                    const find = ["0", "1", "2", "3", "4", "5", "6", "7", "8", "9"];
                    const replace = ["۰", "۱", "۲", "۳", "۴", "۵", "۶", "۷", "۸", "۹"];
                    for (let i = 0; i < find.length; i++) {
                        n = n.replace(new RegExp(find[i], 'g'), replace[i]);
                    }
                    return n;
                }
            },
        }
    }
</script>

