<section class="section menu bb">
    <div class="container">
        <div class="row">
            <div class="col-12 col-sm-6">
                <span class="mr-3">Sort by</span>
                <div class="dropdown" id="btnFilter" style="display: inline-block;" data-sort="latest">
                    <button class="btn btn-primary dropdown-toggle" type="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                        Latest product
                    </button>
                    <div class="dropdown-menu">
                        <a class="dropdown-item" style="cursor: pointer" data-sort="latest">Latest product</a>
                        <a class="dropdown-item" style="cursor: pointer" data-sort="asc">Price (ascending)</a>
                        <a class="dropdown-item" style="cursor: pointer" data-sort="desc">Price (descending)</a>
                    </div>
                </div>
            </div>
            <div class="col-12 col-sm-6 mt-2 mt-sm-0">
                <div class="input-group">
                    <input type="text" class="form-control" name="search" id="search" placeholder="Search for something..." autocomplete="off">
                    <div class="input-group-btn">
                        <button id="btnSearch" class="btn btn-primary">Go</button>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>