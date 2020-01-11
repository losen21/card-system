<?php
use Illuminate\Support\Facades\Schema; use Illuminate\Database\Schema\Blueprint; use Illuminate\Database\Migrations\Migration; class CreatePayWaysTable extends Migration { public function up() { if (Schema::hasColumn('pays', 'img')) { Schema::create('pay_ways', function (Blueprint $sp2bac3d) { $sp2bac3d->increments('id'); $sp2bac3d->string('name', 32)->unique(); $sp2bac3d->integer('sort')->default(1000); $sp2bac3d->string('img')->nullable(); $sp2bac3d->tinyInteger('type')->default(\App\PayWay::TYPE_SHOP); $sp2bac3d->text('channels')->comment('子渠道信息'); $sp2bac3d->text('comment')->nullable(); $sp2bac3d->boolean('enabled')->default(true); $sp2bac3d->timestamps(); }); \App\Pay::each(function (\App\Pay $sp3c5b44) { while (\App\PayWay::where('name', $sp3c5b44->name)->exists()) { $sp3c5b44->name .= '_' . str_random(2); } \App\PayWay::create(array('name' => $sp3c5b44->name, 'img' => $sp3c5b44->img, 'type' => \App\PayWay::TYPE_SHOP, 'sort' => $sp3c5b44->sort, 'enabled' => $sp3c5b44->enabled, 'channels' => array(array($sp3c5b44->id, 1)))); if ($sp3c5b44->enabled > 0) { $sp3c5b44->enabled = true; $sp3c5b44->saveOrFail(); } }); Schema::table('pays', function (Blueprint $sp2bac3d) { $sp2bac3d->dropColumn(array('img', 'sort')); }); } } public function down() { Schema::dropIfExists('pay_ways'); } }