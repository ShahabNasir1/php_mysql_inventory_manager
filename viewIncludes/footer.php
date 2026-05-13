 </div>
</div>

<!-- WHATSAPP -->
<a href="https://wa.me/17132985996" class="wa-bubble" target="_blank" title="Chat on WhatsApp">
  <i class="bi bi-whatsapp"></i>
</a>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
<script>
  // ── PRODUCT DATA ──
 
  let cartCount = 0;
  const wishlist = new Set();
  let allProducts = [...products];

  function discount(p, o) { return Math.round((1 - p/o)*100); }

  function renderProducts(list) {
    const grid = document.getElementById('productsGrid');
    const noRes = document.getElementById('noResults');
    grid.innerHTML = '';
    if (!list.length) { noRes.classList.remove('d-none'); return; }
    noRes.classList.add('d-none');

    list.forEach((p, i) => {
      const col = document.createElement('div');
      col.className = 'col-6 col-md-4 col-xl-3';
      col.innerHTML = `
        <div class="product-card" style="animation-delay:${i*0.06}s">
          ${p.isNew ? '<span class="ribbon">New</span>' : ''}
          <button class="wishlist-btn ${wishlist.has(p.id) ? 'active' : ''}" data-id="${p.id}" title="Add to Wishlist">
            <i class="bi bi-heart${wishlist.has(p.id) ? '-fill' : ''}"></i>
          </button>
          <div class="card-img-wrap">
            <img src="${p.img}" alt="${p.name}" loading="lazy"/>
          </div>
          <div class="price-strip">
            <span class="price-old">US$${p.oldPrice.toFixed(2)}</span>
            <span class="price-current">US$${p.price.toFixed(2)}</span>
          </div>
          <div class="card-body-custom">
            <p class="card-title-custom">${p.name}</p>
            <button class="btn-cart" data-id="${p.id}">
              <i class="bi bi-cart-plus me-1"></i>Add to cart
            </button>
          </div>
        </div>`;
      grid.appendChild(col);
    });

    // Events
    grid.querySelectorAll('.btn-cart').forEach(btn => {
      btn.addEventListener('click', () => {
        cartCount++;
        document.getElementById('cartCount').textContent = cartCount;
        btn.innerHTML = '<i class="bi bi-check-lg me-1"></i>Added!';
        btn.style.background = 'var(--teal)';
        btn.style.color = 'white';
        setTimeout(() => {
          btn.innerHTML = '<i class="bi bi-cart-plus me-1"></i>Add to cart';
          btn.style.background = '';
          btn.style.color = '';
        }, 1500);
      });
    });

    grid.querySelectorAll('.wishlist-btn').forEach(btn => {
      btn.addEventListener('click', () => {
        const id = +btn.dataset.id;
        if (wishlist.has(id)) {
          wishlist.delete(id);
          btn.innerHTML = '<i class="bi bi-heart"></i>';
          btn.classList.remove('active');
        } else {
          wishlist.add(id);
          btn.innerHTML = '<i class="bi bi-heart-fill"></i>';
          btn.classList.add('active');
        }
      });
    });
  }

  // Search
  document.getElementById('searchInput').addEventListener('input', filter);
  document.getElementById('brandFilter').addEventListener('change', filter);

  function filter() {
    const q = document.getElementById('searchInput').value.toLowerCase();
    const brand = document.getElementById('brandFilter').value;
    const filtered = allProducts.filter(p =>
      (!q || p.name.toLowerCase().includes(q)) &&
      (!brand || p.brand === brand)
    );
    renderProducts(filtered);
  }

  // Mobile sidebar
  document.getElementById('sidebarToggle').addEventListener('click', () => {
    const offcanvas = new bootstrap.Offcanvas(document.getElementById('mobileSidebar'));
    offcanvas.show();
  });

  // Init
  renderProducts(allProducts);
</script>
</body>
</html>