<?= loadPartial('head') ?>
<?= loadPartial('navbar') ?>

<!-- Post an Artwork Form Box -->
<section class="flex justify-center items-center mt-20">
      <div class="bg-white p-8 rounded-lg shadow-md w-full md:w-600 mx-6">
        <h2 class="text-4xl text-center font-bold mb-4">Create Artwork Listing</h2>
      
        <form method="POST" action="/artworks">
          <h2 class="text-2xl font-bold mb-6 text-center text-gray-500">
            Artwork Info
          </h2>
          <?= loadPartial('errors', ['errors' => $errors ?? []]) ?>
          <div class="mb-4">
            <input
              type="text"
              name="name"
              placeholder="Artwork Title"
              class="w-full px-4 py-2 border rounded focus:outline-none"
              value = "<?= $artwork['name'] ?? '' ?>"
            />
          </div>
          <div class="mb-4">
            <textarea
              type="text"
              name="description"
              placeholder="Artwork Description"
              class="w-full px-4 py-2 border rounded focus:outline-none"
              <?= $artwork['description'] ?? '' ?>
            ></textarea>
          </div>
          <div class="mb-4">
            <input
              type="text"
              name="tags"
              placeholder="Tags"
              class="w-full px-4 py-2 border rounded focus:outline-none"
              value = "<?= $artwork['tags'] ?? ''?>"
            />
          </div>
          <div class="mb-4">
            <input
              type="text"
              name="image"
              placeholder="Image"
              class="w-full px-4 py-2 border rounded focus:outline-none"
              value = "<?= $artwork['image'] ?? ''?>"
            />
          </div>

          <h2 class="text-2xl font-bold mb-6 text-center text-gray-500">
            Original Information If Available
          </h2>
          <div class="mb-4">
            <input
              type="boolean"
              name="original"
              placeholder="Original Available"
              class="w-full px-4 py-2 border rounded focus:outline-none"
              value = "<?= $artwork['original'] ?? '' ?>"
            />
          </div>
          <div class="mb-4">
            <input
              type="text"
              name="substrate"
              placeholder="Original Substrate"
              class="w-full px-4 py-2 border rounded focus:outline-none"
              value = "<?= $artwork['substrate'] ?? '' ?>"
            />
          </div>
          <div class="mb-4">
            <textarea
              type="int"
              name="price"
              placeholder="Original Price"
              class="w-full px-4 py-2 border rounded focus:outline-none"
              <?= $artwork['price'] ?? '' ?>
            ></textarea>
          </div>
          
          <div class="mb-4">
            <input
              type="boolean"
              name="landscape"
              placeholder="Landscape"
              class="w-full px-4 py-2 border rounded focus:outline-none"
              value = "<?= $artwork['landscape'] ?? ''?>"
            />
          </div>
          <div class="mb-4">
            <input
              type="boolean"
              name="featured"
              placeholder="Featured"
              class="w-full px-4 py-2 border rounded focus:outline-none"
              value = "<?= $artwork['featured'] ?? ''?>"
            />
          </div>
          
          <button
            class="w-full bg-green-500 hover:bg-green-600 text-white px-4 py-2 my-3 rounded focus:outline-none"
          >
            Save
          </button>
          <a
            href="/"
            class="block text-center w-full bg-red-500 hover:bg-red-600 text-white px-4 py-2 rounded focus:outline-none"
          >
            Cancel
          </a>
        </form>
      </div>
    </section>


<?= loadPartial('bottom-banner') ?>
<?= loadPartial('footer') ?>