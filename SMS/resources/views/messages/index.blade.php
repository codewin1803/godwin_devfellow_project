Route::middleware(['auth'])->group(function () {

    // Threads
    Route::get('messages', [MessageThreadController::class, 'index'])->name('messages.index');
    Route::get('messages/create', [MessageThreadController::class, 'create'])->name('messages.create');
    Route::post('messages', [MessageThreadController::class, 'store'])->name('messages.store');
    Route::get('messages/{thread}', [MessageThreadController::class, 'show'])->name('messages.show');

    // Messages (replies, attachments)
    Route::post('messages/{thread}/send', [MessageController::class, 'store'])->name('messages.send');
    Route::get('messages/attachment/{message}', [MessageController::class, 'attachmentDownload'])->name('messages.attachment');
    Route::post('messages/{message}/mark-read', [MessageController::class, 'markRead'])->name('messages.markread');

});