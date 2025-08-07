<?php

namespace App\Filament\Resources;

use App\Filament\Resources\UserResource\Pages;
use App\Filament\Resources\UserResource\RelationManagers;
use App\Models\User;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Actions\ActionGroup;
use Filament\Tables\Columns\IconColumn;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;

class UserResource extends Resource
{
    protected static ?string $model = User::class;

    protected static ?string $navigationIcon = 'heroicon-o-users';
    protected static ?string $modelLabel = 'Usuário';

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                //
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                TextColumn::make('name')
                ->label('Nome')
                ->sortable()
                ->searchable(),

                TextColumn::make('email')
                ->label('Email')
                ->searchable(),

                 IconColumn::make('is_admin')
                 ->label('Admin?')
                 ->boolean()
                //  ->icon(function($state) {
                //     return $state =='1' ? 'heroicon-o-check-circle' : 'heroicon-o-x-circle';
                //  })
                //  ->color(function($state) {
                //     return $state =='1' ? 'success' : 'danger';
                //  })
                 ->sortable(),

                TextColumn::make('phone')
                ->label('Telefone')
                ->searchable()
                ->toggleable(isToggledHiddenByDefault:true),


                TextColumn::make('created_at')
                ->label('Criado em')
                ->toggleable(isToggledHiddenByDefault:true)
                ->date('d/m/Y'),

                TextColumn::make('updated_at')
                ->label('Atualizado em')
                ->toggleable(isToggledHiddenByDefault:true)
                ->date('d/m/Y'),
            ])
            ->filters([
                //
            ])
            ->actions([
                ActionGroup::make([
                    Tables\Actions\EditAction::make(),
                    Tables\Actions\DeleteAction::make(),
                ])
            ])
            ->bulkActions([
                Tables\Actions\BulkActionGroup::make([
                    Tables\Actions\DeleteBulkAction::make(),
                ]),
            ]);
    }

    public static function getRelations(): array
    {
        return [
            //
        ];
    }

    public static function getPages(): array
    {
        return [
            'index' => Pages\ListUsers::route('/'),
            'create' => Pages\CreateUser::route('/create'),
            'edit' => Pages\EditUser::route('/{record}/edit'),
        ];
    }
}
