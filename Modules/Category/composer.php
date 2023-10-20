<?php

// Dashboard ViewComposr
view()->composer([
  'category::dashboard.categories.*',
  'product::dashboard.products.*',
], \Modules\Category\ViewComposers\Dashboard\CategoryComposer::class);
