@extends('layouts.layout')

    <script src="https://cdn.tailwindcss.com"></script>

    
@section('content')

@include('components.propis.subheader', ['titol' => 'Inici'])



<div class="max-w-4xl mx-auto relative overflow-hidden mt-6">
    <div class="carousel relative w-full h-64 md:h-80">
        <img src="https://encrypted-tbn0.gstatic.com/images?q=tbn:ANd9GcTmHvK09MwGO6Expe3tJuuKj-J_WT1YWcQNaQ&s" class="absolute inset-0 w-full h-full object-cover active">
        <img src="https://encrypted-tbn0.gstatic.com/images?q=tbn:ANd9GcTmHvK09MwGO6Expe3tJuuKj-J_WT1YWcQNaQ&s" class="absolute inset-0 w-full h-full object-cover">
        <img src="https://res.cloudinary.com/playtomic/image/upload/c_scale,w_1080,q_80,f_auto/pro/tenants/d5cc638a-fb46-4fb8-8771-876b61b8661f/1772117729711" class="absolute inset-0 w-full h-full object-cover">
        <img src="https://encrypted-tbn0.gstatic.com/images?q=tbn:ANd9GcRZ8e1EGTvqdccQXTtL8lLUwTPzTQjY_7Vb1g&s" class="absolute inset-0 w-full h-full object-cover">
        <img src="https://res.cloudinary.com/playtomic/image/upload/c_scale,w_1080,q_80,f_auto/pro/tenants/d5cc638a-fb46-4fb8-8771-876b61b8661f/1772117729711" class="absolute inset-0 w-full h-full object-cover">
        <img src="https://encrypted-tbn0.gstatic.com/images?q=tbn:ANd9GcRZ8e1EGTvqdccQXTtL8lLUwTPzTQjY_7Vb1g&s" class="absolute inset-0 w-full h-full object-cover">

        <!-- Botones -->
        <button class="prev absolute left-2 top-1/2 transform -translate-y-1/2 bg-black bg-opacity-50 text-white p-2 rounded-full hover:bg-opacity-70">
            &#10094;
        </button>
        <button class="next absolute right-2 top-1/2 transform -translate-y-1/2 bg-black bg-opacity-50 text-white p-2 rounded-full hover:bg-opacity-70">
            &#10095;
        </button>
    </div>
</div>

<script>
document.addEventListener('DOMContentLoaded', () => {
    let index = 0;
    const images = document.querySelectorAll(".carousel img");
    const total = images.length;

    // Muestra la primera
    images[index].classList.add("active");

    function showImage(i) {
        images.forEach(img => img.classList.remove("active"));
        images[i].classList.add("active");
    }

    let interval = setInterval(() => {
        index = (index + 1) % total;
        showImage(index);
    }, 3000);

    document.querySelector(".prev").addEventListener("click", () => {
        index = (index - 1 + total) % total;
        showImage(index);
        resetInterval();
    });

    document.querySelector(".next").addEventListener("click", () => {
        index = (index + 1) % total;
        showImage(index);
        resetInterval();
    });

    function resetInterval() {
        clearInterval(interval);
        interval = setInterval(() => {
            index = (index + 1) % total;
            showImage(index);
        }, 3000);
    }
});
</script>

@endsection