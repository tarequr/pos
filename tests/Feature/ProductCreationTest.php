<?php

use App\Models\Branch;
use App\Models\Category;
use App\Models\User;
use App\Models\Product;

beforeEach(function () {
    $this->user = User::factory()->create();
    $this->branch = Branch::create(['name' => 'Main Branch', 'slug' => 'main-branch', 'status' => true]);
    $this->category = Category::create(['name' => 'Electronics', 'slug' => 'electronics', 'status' => true]);
});

test('can create product via single entry', function () {
    $response = $this->actingAs($this->user)->post(route('products.store'), [
        'category_id' => $this->category->id,
        'branch_id' => $this->branch->id,
        'serial_type' => 'single',
        'serial_no' => '123456'
    ]);

    $response->assertRedirect(route('products.index'));
    expect(Product::where('serial_no', '123456')->exists())->toBeTrue();
});

test('can create products via custom bulk entry', function () {
    $serials = ['SN-001', 'SN-002', 'SN-003'];
    
    $response = $this->actingAs($this->user)->post(route('products.store'), [
        'category_id' => $this->category->id,
        'branch_id' => $this->branch->id,
        'serial_type' => 'custom',
        'custom_serials' => $serials
    ]);

    $response->assertRedirect(route('products.index'));
    foreach ($serials as $serial) {
        expect(Product::where('serial_no', $serial)->exists())->toBeTrue();
    }
});

test('cannot create product with duplicate serial', function () {
    Product::create([
        'category_id' => $this->category->id,
        'branch_id' => $this->branch->id,
        'serial_no' => 'DUP-123',
        'status' => 'stock_in'
    ]);

    $response = $this->actingAs($this->user)->post(route('products.store'), [
        'category_id' => $this->category->id,
        'branch_id' => $this->branch->id,
        'serial_type' => 'single',
        'serial_no' => 'DUP-123'
    ]);

    $response->assertSessionHasErrors('serial_no');
});

test('cannot exceed 200 serials in custom bulk entry', function () {
    $serials = array_map(fn($i) => "SN-$i", range(1, 201));
    
    $response = $this->actingAs($this->user)->post(route('products.store'), [
        'category_id' => $this->category->id,
        'branch_id' => $this->branch->id,
        'serial_type' => 'custom',
        'custom_serials' => $serials
    ]);

    $response->assertSessionHasErrors('custom_serials');
});

test('cannot exceed 200 serials in range entry', function () {
    $response = $this->actingAs($this->user)->post(route('products.store'), [
        'category_id' => $this->category->id,
        'branch_id' => $this->branch->id,
        'serial_type' => 'range',
        'serial_start' => 1,
        'serial_end' => 201
    ]);

    $response->assertSessionHasErrors('serial_end');
});
