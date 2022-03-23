<template>
    <div class="container"> 
        <nav class="navbar navbar-expand-lg navbar-dark bg-dark">
            <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarNav" aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
                <span class="navbar-toggler-icon"></span>
            </button>
            <div class="collapse navbar-collapse" id="navbarNav">
                <ul class="navbar-nav">
                    <li class="nav-item">
                        <router-link to="/" class="nav-link">Products List<span class="sr-only">(current)</span></router-link>
                    </li>
                    <li class="nav-item">
                        <router-link to="/create" class="nav-link">Create Product<span class="sr-only">(current)</span></router-link>
                    </li>
                </ul>
            </div>
        </nav>

        <router-view> </router-view>
    </div>
</template>
 
<script>
    console.log('Estou aqui => App.vue');
    export default {}
</script>