<h1>Ascent Creative Model Approvals</h1>

<p>This package allows for the creation of approvals processes which prevent newly created models (or edits to existing models) being put live without admin approval</p>

<h2>Requirements</h2>
<ul>
    <li>Laravel 11+</li>
    <li>ascentcreative/cms</li>
    <li>ascentcreative/forms</li>
</ul>

<h2>Setting up approvals</h2>
<ol>
    <li>
        Add the `AscentCreative\Approval\Traits\Approvable` trait to your model
    </li>
    <li>
        Use a migration to add approval columns to your table:
        ```
        public function up(Blueprint $table) {
            ...
            $table->approvals();
            ...
        }
        ```
    </li>
</ol>
