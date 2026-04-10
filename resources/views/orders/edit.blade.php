<x-app-layout>
    <div class="py-12">
        <div class="max-w-3xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white shadow-xl sm:rounded-lg border border-gray-200">
                <div class="p-8">
                    <div class="flex items-center justify-between mb-8 border-b pb-6">
                        <div>
                            <h2 class="text-2xl font-black text-gray-800 tracking-tight">Update Order Status</h2>
                            <p class="text-sm text-gray-500 font-medium">Order: <span
                                    class="text-primary-600 font-bold">{{ $order->reference_no }}</span></p>
                        </div>
                        <span
                            class="inline-flex items-center px-3 py-1 bg-gray-100 text-gray-600 rounded-full text-xs font-black uppercase tracking-widest border border-gray-200">
                            Current: {{ $order->status }}
                        </span>
                    </div>

                    <form action="{{ route('orders.update', $order) }}" method="POST">
                        @csrf
                        @method('PATCH')

                        <div class="mb-8">
                            <label
                                class="block text-xs font-black text-gray-400 uppercase tracking-widest mb-3">Transition
                                to Status</label>
                            <div class="grid grid-cols-1 md:grid-cols-3 gap-4">
                                <label
                                    class="relative flex flex-col p-4 bg-yellow-50 rounded-xl border-2 border-transparent hover:border-yellow-400 cursor-pointer transition-all has-[:checked]:border-yellow-500 has-[:checked]:bg-yellow-100 group">
                                    <input type="radio" name="status" value="pending" class="hidden"
                                        {{ $order->status == 'pending' ? 'checked' : '' }}>
                                    <span class="text-yellow-800 font-black uppercase text-xs tracking-widest mb-1">Set
                                        Pending</span>
                                    <span class="text-[10px] text-yellow-600 leading-tight">Order is received but not
                                        yet fulfilled.</span>
                                </label>

                                <label
                                    class="relative flex flex-col p-4 bg-green-50 rounded-xl border-2 border-transparent hover:border-green-400 cursor-pointer transition-all has-[:checked]:border-green-500 has-[:checked]:bg-green-100 group">
                                    <input type="radio" name="status" value="completed" class="hidden"
                                        {{ $order->status == 'completed' ? 'checked' : '' }}>
                                    <span class="text-green-800 font-black uppercase text-xs tracking-widest mb-1">Mark
                                        Completed</span>
                                    <span class="text-[10px] text-green-600 leading-tight">Stock is moved and
                                        transaction is closed.</span>
                                </label>

                                <label
                                    class="relative flex flex-col p-4 bg-red-50 rounded-xl border-2 border-transparent hover:border-red-400 cursor-pointer transition-all has-[:checked]:border-red-500 has-[:checked]:bg-red-100 group">
                                    <input type="radio" name="status" value="cancelled" class="hidden"
                                        {{ $order->status == 'cancelled' ? 'checked' : '' }}>
                                    <span class="text-red-800 font-black uppercase text-xs tracking-widest mb-1">Cancel
                                        Order</span>
                                    <span class="text-[10px] text-red-600 leading-tight">Void this transaction and stop
                                        processing.</span>
                                </label>
                            </div>
                        </div>

                        <div class="flex items-center justify-end space-x-4 border-t pt-6">
                            <a href="{{ route('orders.index') }}"
                                class="text-sm font-bold text-gray-400 hover:text-gray-600 transition">Go Back</a>
                            <button type="submit"
                                class="bg-gray-900 text-white font-black uppercase tracking-widest text-xs px-8 py-3 rounded-md hover:bg-black shadow-lg transition duration-200">
                                Confirm Transition
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
