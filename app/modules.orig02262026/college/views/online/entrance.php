<style>
    /* Body & Container */
    body,
    html {
        margin: 0;
        padding: 0;
        height: 100%;
        font-family: Arial, sans-serif;
        background: #f3f3fc;
        overflow-x: hidden;
    }

    .main-container {
        position: relative;
        min-height: 100vh;
        overflow: hidden;
        display: flex;
        justify-content: center;
        align-items: center;
    }

    /* Background Blur Layer */
    .main-container::before {
        content: "";
        position: absolute;
        top: 0;
        left: 0;
        right: 0;
        bottom: 0;
        background: url("<?php echo base_url() ?>images/portal-bg.png") no-repeat center center;
        background-size: cover;
        filter: blur(5px);
        /* adjust blur strength */
        transform: scale(1.1);
        /* prevent edges from showing after blur */
        z-index: 0;
    }

    /* Floating Shapes */
    .floating-shape {
        position: absolute;
        border-radius: 50%;
        opacity: 0.25;
        z-index: 0;
        pointer-events: none;
    }

    .shape1 {
        width: 200px;
        height: 200px;
        top: 10%;
        left: 5%;
        background: rgba(255, 255, 255, 0.2);
        filter: blur(60px);
        animation: float1 20s ease-in-out infinite alternate;
    }

    .shape2 {
        width: 250px;
        height: 250px;
        bottom: 15%;
        right: 10%;
        background: rgba(255, 193, 7, 0.2);
        filter: blur(80px);
        animation: float2 25s ease-in-out infinite alternate;
    }

    .shape3 {
        width: 150px;
        height: 150px;
        top: 40%;
        right: 25%;
        background: rgba(23, 162, 184, 0.2);
        filter: blur(50px);
        animation: float3 22s ease-in-out infinite alternate;
    }

    @keyframes float1 {
        0% {
            transform: translate(0, 0) rotate(0deg);
        }

        100% {
            transform: translate(30px, 20px) rotate(360deg);
        }
    }

    @keyframes float2 {
        0% {
            transform: translate(0, 0) rotate(0deg);
        }

        100% {
            transform: translate(-25px, -15px) rotate(-360deg);
        }
    }

    @keyframes float3 {
        0% {
            transform: translate(0, 0) rotate(0deg);
        }

        100% {
            transform: translate(20px, -25px) rotate(360deg);
        }
    }

    /* Particles */
    .particles .particle {
        position: absolute;
        background: rgba(0, 123, 255, 0.3);
        border-radius: 50%;
        animation-name: drift;
        animation-timing-function: linear;
        animation-iteration-count: infinite;
        pointer-events: none;
    }

    @keyframes drift {
        0% {
            transform: translate(0, 0) rotate(0deg);
        }

        50% {
            transform: translate(30px, -20px) rotate(180deg);
        }

        100% {
            transform: translate(-15px, 25px) rotate(360deg);
        }
    }

    /* Card Container */
    .card-container {
        position: relative;
        max-width: 700px;
        width: 90%;
        padding: 50px;
        background: rgba(255, 255, 255, 0.95);
        border-radius: 2rem;
        box-shadow: 0 15px 30px rgba(0, 0, 0, 0.15);
        z-index: 2;
        /* stays above blurred bg */
        text-align: center;
    }

    /* Logo Animation */
    .animate-fade-scale {
        opacity: 0;
        animation: fadeScale 0.8s ease forwards;
    }

    @keyframes fadeScale {
        0% {
            opacity: 0;
            transform: scale(0.8);
        }

        100% {
            opacity: 1;
            transform: scale(1);
        }
    }

    /* School Name & Address Animation */
    .animate-fade-up {
        opacity: 0;
        animation: fadeUp 0.8s ease forwards;
    }

    @keyframes fadeUp {
        0% {
            opacity: 0;
            transform: translateY(20px);
        }

        100% {
            opacity: 1;
            transform: translateY(0);
        }
    }

    /* Button Slide Up */
    .animate-slide-up {
        opacity: 0;
        animation: slideUp 0.8s ease forwards;
    }

    @keyframes slideUp {
        0% {
            opacity: 0;
            transform: translateY(40px);
        }

        100% {
            opacity: 1;
            transform: translateY(0);
        }
    }

    /* Buttons Row */
    .buttons-row {
        display: flex;
        justify-content: center;
        gap: 20px;
        flex-wrap: wrap;
        margin-top: 30px;
    }

    /* Buttons */
    .buttons-row .btn {
        padding: 22px 0;
        font-size: 1.4rem;
        font-weight: 700;
        border-radius: 1.5rem;
        position: relative;
        overflow: hidden;
        color: white;
        flex: 1 1 200px;
        max-width: 240px;
        display: flex;
        flex-direction: column;
        align-items: center;
        justify-content: center;
        transition: all 0.4s ease;
    }

    .buttons-row .btn i {
        margin-bottom: 12px;
        font-size: 2.2rem;
        display: block;
    }

    /* Gradient hover shine */
    .btn::before {
        content: '';
        position: absolute;
        top: 0;
        left: -50%;
        width: 200%;
        height: 100%;
        background: linear-gradient(60deg, rgba(255, 255, 255, 0.2), rgba(255, 255, 255, 0), rgba(255, 255, 255, 0.2));
        transform: skewX(-20deg);
        transition: all 0.5s ease;
    }

    .btn:hover::before {
        left: 50%;
    }

    /* Button Colors */
    .btn-success {
        background: linear-gradient(45deg, #28a745, #71dd8a);
        box-shadow: 0 5px 15px rgba(0, 0, 0, 0.15);
    }

    .btn-success:hover {
        transform: translateY(-8px) scale(1.07);
        box-shadow: 0 14px 28px rgba(0, 0, 0, 0.3);
    }

    .btn-primary {
        background: linear-gradient(45deg, #007bff, #66b2ff);
        box-shadow: 0 5px 15px rgba(0, 0, 0, 0.15);
    }

    .btn-primary:hover {
        transform: translateY(-8px) scale(1.07);
        box-shadow: 0 14px 28px rgba(0, 0, 0, 0.3);
    }

    .btn-info {
        background: linear-gradient(45deg, #17a2b8, #5ac8d6);
        box-shadow: 0 5px 15px rgba(0, 0, 0, 0.15);
    }

    .btn-info:hover {
        transform: translateY(-8px) scale(1.07);
        box-shadow: 0 14px 28px rgba(0, 0, 0, 0.3);
    }
</style>
<div class="main-container">
    <!-- Floating Shapes -->
    <div class="floating-shape shape1"></div>
    <div class="floating-shape shape2"></div>
    <div class="floating-shape shape3"></div>

    <!-- Particles -->
    <div class="particles">
        <div class="particle" style="top:20%; left:15%; width:10px; height:10px; animation-duration:18s; opacity:0.6;"></div>
        <div class="particle" style="top:50%; left:70%; width:12px; height:12px; animation-duration:22s; opacity:0.5;"></div>
        <div class="particle" style="top:75%; left:40%; width:8px; height:8px; animation-duration:15s; opacity:0.4;"></div>
        <div class="particle" style="top:30%; left:80%; width:10px; height:10px; animation-duration:20s; opacity:0.6;"></div>
        <div class="particle" style="top:60%; left:25%; width:9px; height:9px; animation-duration:19s; opacity:0.5;"></div>
    </div>

    <!-- Card -->
    <div class="card-container">
        <!-- Logo -->
        <div class="animate-fade-scale">
            <img src="<?php echo base_url() . 'images/forms/' . $settings->set_logo ?>" style="width:160px; border-radius:50%; padding:15px; background:white; box-shadow:0 5px 15px rgba(0,0,0,0.1);" />
        </div>

        <!-- School Name & Address -->
        <h1 class="animate-fade-up" style="animation-delay:0.3s;"><?php echo $settings->set_school_name ?></h1>
        <h6 class="animate-fade-up" style="animation-delay:0.5s; color:#555;"><?php echo $settings->set_school_address ?></h6>

        <!-- Buttons Row -->
        <div class="buttons-row">
            <button class="btn btn-success animate-slide-up" style="animation-delay:0.7s;" onclick="window.location='<?php echo base_url() . 'studentsEntrance' ?>'">
                <i class="fa fa-graduation-cap"></i> Student Login
            </button>
            <button class="btn btn-primary animate-slide-up" style="animation-delay:0.9s;" onclick="window.location='<?php echo base_url() . 'parentsEntrance' ?>'">
                <i class="fa fa-users"></i> Parent Login
            </button>
            <button class="btn btn-info animate-slide-up" style="animation-delay:1.1s;" onclick="window.location='<?php echo base_url() . 'enrollment' ?>'">
                <i class="fa fa-globe"></i> Online Enrollment
            </button>
        </div>
    </div>
</div>

<script>
    // Mouse parallax effect
    document.addEventListener('mousemove', (e) => {
        const shapes = document.querySelectorAll('.floating-shape, .particles .particle');
        const x = e.clientX / window.innerWidth - 0.5;
        const y = e.clientY / window.innerHeight - 0.5;
        shapes.forEach((el, index) => {
            const factor = (index + 1) * 5;
            el.style.transform = `translate(${x*factor}px, ${y*factor}px)`;
        });
    });
</script>