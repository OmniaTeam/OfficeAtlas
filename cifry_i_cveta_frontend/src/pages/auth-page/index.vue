<template>
    <div class="auth-page">
        <div class="service-name fade-in">Service Name</div>
        <div class="auth-section fade-in">
            <div class="auth-card slide-in">
                <h1>Добро пожаловать!</h1>
                <p>Войдите, чтобы начать пользоваться</p>
                <el-button type="primary" class="auth-button" @click="handleClick"> Войти через Keycloak </el-button>
            </div>
        </div>
        <div class="background-shapes">
            <div class="shape shape1 scale-in"></div>
            <div class="shape shape2 scale-in"></div>
            <div class="shape shape3 scale-in"></div>
            <div class="shape shape4 scale-in"></div>
            <div class="shape shape5 scale-in"></div>
            <div class="shape shape6 scale-in"></div>
        </div>
        <div class="footer fade-in">created by Omnia</div>
    </div>
</template>

<script lang="ts" setup>
import { ElButton } from 'element-plus'

const handleClick = () => {
    console.log('Войти через Keycloak')
}
</script>

<style scoped>
@keyframes fadeIn {
    0% {
        opacity: 0;
    }
    100% {
        opacity: 1;
    }
}

@keyframes slideIn {
    0% {
        opacity: 0;
        transform: translateY(20px);
    }
    100% {
        opacity: 1;
        transform: translateY(0);
    }
}

@keyframes scaleIn {
    0% {
        opacity: 0;
        transform: scale(0.8);
    }
    100% {
        opacity: 0.8;
        transform: scale(1);
    }
}

.fade-in {
    animation: fadeIn 1s ease-out forwards;
}

.slide-in {
    animation: slideIn 0.8s ease-out forwards;
}

.scale-in {
    animation: scaleIn 1.2s ease-out forwards;
}

.auth-page {
    display: flex;
    flex-direction: column;
    align-items: flex-start;
    justify-content: center;
    height: 100vh;
    background-color: #ffffff;
    overflow: hidden;
    font-family: Arial, sans-serif;
    position: relative;
    padding-left: 10%;
    transition: all 0.3s ease-in-out;
}

.service-name {
    position: absolute;
    top: 20px;
    left: 20px;
    font-size: 1rem;
    color: #000;
}

.auth-section {
    z-index: 10;
}

.auth-card {
    background-color: #fff;
    padding: 20px 30px;
    text-align: left;
    width: 400px;
    transition: all 0.3s ease-in-out;
    position: relative;
}

.auth-card h1 {
    font-size: 1.25rem;
    font-weight: bold;
    margin-bottom: 10px;
    color: #333;
}

.auth-card p {
    font-size: 0.9rem;
    color: #666;
    margin-bottom: 20px;
}

.auth-button {
    width: 100%;
    background-color: #409eff;
    border-radius: 4px;
    font-size: 0.875rem;
    padding: 10px;
    transition: all 0.3s ease-in-out;
}

.background-shapes {
    position: absolute;
    top: 0;
    right: 0;
    width: 100%;
    height: 100%;
    z-index: 0;
    overflow: hidden;
    display: flex;
    justify-content: flex-end;
    align-items: flex-end;
    flex-wrap: wrap;
}

.shape {
    position: absolute;
    opacity: 0.8;
    border-radius: 8px;
    transition: all 0.3s ease-in-out;
}

.shape1 {
    width: 25vw;
    height: 25vw;
    right: 5%;
    top: -7%;
    background-color: #409eff;
    z-index: 1000;
}

.shape2 {
    width: 10vw;
    height: 10vw;
    top: 48%;
    right: 17%;
    background-color: #409eff;
    z-index: 10000;
}

.shape3 {
    width: 25vw;
    height: 25vw;
    top: 30%;
    left: 80%;
    background-color: #79bbff;
    z-index: 100;
}

.shape4 {
    width: 7vw;
    height: 7vw;
    right: 1%;
    top: 10%;
    background-color: #9fceff;
}

.shape5 {
    width: 5vw;
    height: 5vw;
    top: 86%;
    right: 5.5%;
    background-color: #79bbff;
    z-index: 1000000;
}

.shape6 {
    width: 25vw;
    height: 25vw;
    top: 62%;
    right: 8%;
    background-color: #9fceff;
}

.footer {
    position: absolute;
    bottom: 10px;
    left: 20px;
    font-size: 0.75rem;
    color: #aaa;
}
@media (max-width: 1665px) {
    .shape1 {
        top: -2%;
    }
    .shape2 {
        top: 44%;
    }
    .shape5 {
        top: 84%;
    }
}
@media (max-width: 1500px) {
    .shape1 {
        top: 0;
    }
    .shape2 {
        top: 40%;
    }
    .shape3 {
        top: 25%;
    }
    .shape5 {
        top: 65%;
    }
    .shape6 {
        top: 48%;
    }
}
@media (max-width: 1000px) {
    .shape2 {
        top: 30%;
    }
    .shape3 {
        top: 20%;
    }
    .shape5 {
        top: 50%;
    }
    .shape6 {
        top: 35%;
    }
}
@media (max-width: 850px) {
    .auth-card {
        width: 80%;
        padding: 15px 20px;
    }

    .auth-card h1 {
        font-size: 1rem;
    }

    .auth-card p {
        font-size: 0.8rem;
    }

    .auth-button {
        font-size: 0.8rem;
        padding: 8px;
    }
}

@media (max-width: 480px) {
    .auth-page {
        padding-left: 5%;
    }

    .auth-card {
        width: 90%;
        padding: 10px 15px;
    }

    .auth-card h1 {
        font-size: 0.9rem;
    }

    .auth-card p {
        font-size: 0.75rem;
    }

    .auth-button {
        font-size: 0.75rem;
        padding: 6px;
    }

    .shape {
        width: 10vw;
        height: 10vw;
    }
}

@media (max-width: 440px) {
    .background-shapes {
        display: none;
    }

    .auth-page {
        align-items: center;
        justify-content: center;
        padding-left: 0;
    }

    .auth-card {
        position: static;
        text-align: center;
        transform: none;
        margin: 0 auto;
    }
}
</style>
