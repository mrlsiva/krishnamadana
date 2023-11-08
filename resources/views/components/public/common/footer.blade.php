<?php use App\Http\Livewire\Public\Category\CategoryList;
  $mainCategories =  CategoryList::Categories();
  ?>
<footer>
    <div class="flex w-full justify-around">
        <div class="flex flex-col">
            <h3>Our Products</h3>
            <nav>
                <ul>
                   <!-- <li><a href="">Sarees</a></li>
                    <li><a href="">Kurtas</a></li>
                    <li><a href="">Blouses</a></li>
                    <li><a href="">Dresses</a></li>
                    <li><a href="">Lehengas</a></li>
                    <li><a href="">Men's Kurtas</a></li> -->
					@foreach($mainCategories as $cat)
					  <li><a href="{{ route('home.collections', ['slug' => $cat->slug]) }}">{{ $cat->name }}</a></li>
					@endforeach 
                </ul>
            </nav>
        </div>
        <div class="flex flex-col">
            <h3>Our Policies</h3>
            <nav>
                <ul>
                    <li><a href="">Terms of Service</a></li>
                    <li><a href="">Shipping Policy</a></li>
                    <li><a href="">Refund Policy</a></li>
                    <li><a href="">Privacy Policy</a></li>
                </ul>
            </nav>
        </div>
        <div class="flex flex-col">
            <h3>Useful Links</h3>
            <nav>
                <ul>
                    <li><a href="/about-us">About us</a></li>
                    <li><a href="">Blogs</a></li>
                    <li><a href="">FAQs</a></li>
                    <li><a href="">Track My Order</a></li>
                    <li><a href="/login">Login</a></li>
                    <li><a href="/contact-us">Contact</a></li>
                </ul>
            </nav>
        </div>
        <div class="flex flex-col">
            <h3>Follow Us At</h3>
            <div class="flex">
                <a href="" class="mr-5"><img src="/images/ic_facebook.png" alt=""></a>
                <a href=""><img src="/images/ic_instagram.png" alt=""></a>
            </div>
        </div>
    </div>
    <div class="flex w-full justify-around mt-4 copyright">
        © KRISHNA MADANA
    </div>
</footer>
